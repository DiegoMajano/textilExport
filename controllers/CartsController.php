<?php

require_once 'core/Controller.php';
require_once 'model/CartsModel.php';
require_once 'model/ProductsModel.php';

class CartsController extends Controller
{
    private $cartsModel;
    private $productsModel;

    public function __construct()
    {
        $this->cartsModel = new CartsModel();
        $this->productsModel = new  ProductsModel();
    }

    public function index($user_id)
    {
        $products = $this->productsModel->get();
        $cartItems = 0;
        if (isset($_GET['show_cart']) && $_GET['show_cart'] === 'true') {
            $cartItems = $this-> cartsModel->getByUser($user_id); 
        }

        
        $this->view('products/index', ['cartItems' => $cartItems, 'products' => $products]);
    }

    public function show()
    {
        if (!isset($_SESSION['user_id'])) {
            echo '<p>No hay sesión iniciada.</p>';
            return;
        }
    
        $cartItems = $this->cartsModel->getByUser($_SESSION['user_id']);
    
        if (empty($cartItems)) {
            echo '<p>El carrito está vacío.</p>';
            return;
        }
    
        $total = 0;
        foreach ($cartItems as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
    
            echo "<div class='mb-3 border-bottom pb-2'>
                    <form method='POST' action='" . PATH . "/carts/updateItem' class='d-flex justify-content-between align-items-center'>
                        <div>
                            <strong>" . htmlspecialchars($item['product']) . "</strong><br>
                            <span>Precio: \$" . number_format($item['price'], 2) . "</span><br>
                            <span>Subtotal: \$" . number_format($subtotal, 2) . "</span><br>
                            <input type='hidden' name='product_id' value='{$item['product_id']}'>
                            <input type='hidden' name='user_id' value='{$_SESSION['user_id']}'>
                        </div>
                        <div class='d-flex align-items-center gap-2'>
                            <input type='number' name='quantity' value='{$item['quantity']}' min='1' class='form-control form-control-sm' style='width: 60px;'>
                            <button type='submit' class='btn btn-sm btn-primary'>Actualizar</button>
                    </form>
                    <form method='POST' action='" . PATH . "/carts/deleteItem' class='ms-2'>
                        <input type='hidden' name='product_id' value='{$item['product_id']}'>
                        <input type='hidden' name='user_id' value='{$_SESSION['user_id']}'>
                        <button type='submit' class='btn btn-sm btn-danger' onclick='return confirm(\"¿Eliminar este producto?\")'>X</button>
                    </form>
                        </div>
                </div>";
        }
    
        echo "<hr><div class='d-flex justify-content-between'>
                <strong>Total: \$" . number_format($total, 2) . "</strong>
            </div>";
    
        echo "<form method='POST' action='" . PATH . "/sales/create' onsubmit='return confirm(\"¿Confirmar compra?\")'>";
        echo "<input type='hidden' name='user_id' value='" . $_SESSION['user_id'] . "'>";
    
        foreach ($cartItems as $item) {
            echo "<input type='hidden' name='products[{$item['product_id']}][quantity]' value='{$item['quantity']}'>";
            echo "<input type='hidden' name='products[{$item['product_id']}][price]' value='{$item['price']}'>";
        }
    
        echo "<button type='submit' class='btn btn-success w-100 mt-3'>
                <i class='fas fa-credit-card me-1'></i> Finalizar compra
            </button>";
        echo "</form>";
    
        // Cargar productos vía JS si fuera necesario
        echo "<script>
            fetch('" . PATH . "/api/cartItems?user_id={$_SESSION['user_id']}')
                .then(res => res.json())
                .then(data => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'cart_json';
                    input.value = JSON.stringify(data);
                    document.querySelector(\"form[action^='" . PATH . "/sales/create']\").appendChild(input);
                });
        </script>";
    }
  

    public function create() {
        if (isset($_POST)) {

            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $exists = $this->cartsModel->findByUserAndProduct($user_id, $product_id);

            if ($exists) {
                $_SESSION['error'] = 'Este producto ya está en tu carrito, puedes modificar la cantidad en el carrito.';
                header('Location: ' . PATH . '/products');
                exit;
            }

            $data = [
                ':user_id' => $user_id,
                ':product_id' => $product_id,
                ':quantity' => $quantity,
                ':state' => 1
            ];
            $this->cartsModel->add($data);
            $_SESSION['success'] = 'Producto agregado al carrito.';
            header('Location: '.PATH.'/products');
            exit;
        } else {
            header('Location: '.PATH.'/products');
        }
    }

    public function updateItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];
    
            $this->cartsModel->updateItem($user_id, $product_id, $quantity);
            header('Location: ' . PATH . '/products?show_cart=true');
            exit;
        }
    }
    
    public function deleteItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_POST['user_id'];
            $product_id = $_POST['product_id'];
    
            $this->cartsModel->deleteItem($user_id, $product_id);
            header('Location: ' . PATH . '/products?show_cart=true');
            exit;
        }
    }
    

    public function edit($id) {
        if (isset($_POST)) {
            $data = [
                ':id' => $id,
                ':user_id' => $_POST['user_id'],
                ':product_id' => $_POST['product_id'],
                ':quantity' => $_POST['quantity'],
                ':state' => $_POST['state']
            ];
            $this->cartsModel->update($data);
            header('Location: /carts');
        } else {
            $cart = $this->cartsModel->get($id);
            $this->view('carts/edit', ['cart' => $cart[0] ?? null]);
        }
    }

    public function delete($id) {
        if (isset($_POST)) {
            $this->cartsModel->delete($id);
            header('Location: /carts');
        } else {
            $cart = $this->cartsModel->get($id);
            $this->view('carts/delete', ['cart' => $cart[0] ?? null]);
        }
    }
}

?>
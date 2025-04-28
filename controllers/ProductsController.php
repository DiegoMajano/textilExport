<?php

require_once 'core/Controller.php';
require_once './model/ProductsModel.php';

class ProductsController extends Controller
{

  private $model;

  public function __construct()
  {
    if (empty($_SESSION['user'])) {
      header('Location: ' . PATH . '/users/login');
      exit;
    }
    $this->model = new ProductsModel();
  }

  public function index()
  {
    $search = $_GET['search'] ?? '';
    $products = $this->model->get();

    // Filtrar por búsqueda si es necesario
    if ($search) {
      $products = array_filter($products, function ($product) use ($search) {
        return stripos($product['product'], $search) !== false ||
          stripos($product['description'], $search) !== false;
      });
    }

    $this->view('products/index.php', ['products' => $products]);
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $productData = [
        'product' => $_POST['name'],
        'description' => $_POST['description'],
        'category_id' => $_POST['category'] == 'Textil' ? 1 : 2,
        'price' => $_POST['price'],
        'stock' => $_POST['stock'],
        'state' => 1,
        'image_url' => 'https://definicion.de/wp-content/uploads/2012/01/imagen-vectorial.png'
      ];

      if ($this->model->create($productData)) {
        $_SESSION['success'] = 'Producto creado correctamente';
        header('Location: ' . PATH . '/products');
        exit;
      } else {
        $_SESSION['error'] = 'Error al crear el producto';
        $this->view('products/create.php');
      }
    } else {
      $this->view('products/create.php');
    }
  }


  public function edit($id)
  {
    $product_id = implode(", ", $id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $productData = [
        'product_id' => $product_id,
        'product' => $_POST['name'],
        'description' => $_POST['description'],
        'category_id' => $_POST['category'] == 'Textil' ? 1 : 2,
        'price' => $_POST['price'],
        'stock' => $_POST['stock'],
        'state' => 1,
        'image_url' => 'https://definicion.de/wp-content/uploads/2012/01/imagen-vectorial.png'
      ];

      if ($this->model->update($productData)) {
        $_SESSION['success'] = 'Producto actualizado correctamente';
        header('Location: ' . PATH . '/products');
        exit;
      } else {
        $_SESSION['error'] = 'Error al crear el producto';
        $this->view('products/create.php');
      }
    } else {
      $this->view('products/create.php');
    }
  }

  public function delete($id)
  {
    $this->model->delete($id);
    header('Location: /products');
  }

}
<?php

require_once 'core/Controller.php';
require_once './model/ProductsModel.php';
include_once './utils/validate_fields.php';

class ProductsController extends Controller
{

  private $model;

  public function __construct()
  {
    // if (empty($_SESSION['user'])) {
    //   header('Location: ' . PATH . '/users/login');
    //   exit;
    // }
    $this->model = new ProductsModel();
  }

  public function index()
  {
    $search = $_GET['search'] ?? '';

    if ($search) {
      $products = $this->model->searchByName($search);
    } else {
      $products = $this->model->get();
    }

    $this->view('products/index.php', ['products' => $products]);
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $errors = validateProductFields($_POST['name'], $_POST['description'], $_POST['category'], $_POST['price'], $_POST['stock']);
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors;
        $this->view('products/create.php');
        return;
      }

      $categoryMap = [
        'Cotton' => 1,
        'Linen' => 2,
        'Silk' => 3,
        'Synthetic' => 5,
        'Wool' => 4
      ];

      $category_id = $categoryMap[$_POST['category']] ?? null;

      if ($category_id === null) {
        $_SESSION['error'] = 'Categoría inválida';
        $this->view('products/create.php');
        return;
      }

      $productData['category_id'] = $category_id;
      $productData = [
        'product' => $_POST['name'],
        'description' => $_POST['description'],
        'category_id' => $category_id,
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
      $errors = validateProductFields($_POST['name'], $_POST['description'], $_POST['category'], $_POST['price'], $_POST['stock']);
      if (count($errors) > 0) {
        $_SESSION['error'] = $errors;
        header(header: 'Location: ' . PATH . '/products');
        return;
      }
      $categoryMap = [
        'Cotton' => 1,
        'Linen' => 2,
        'Silk' => 3,
        'Synthetic' => 5,
        'Wool' => 4
      ];

      $category_id = $categoryMap[$_POST['category']] ?? null;

      if ($category_id === null) {
        $_SESSION['error'] = 'Categoría inválida';
        $this->view('products/create.php');
        return;
      }
      $productData = [
        'product_id' => $product_id,
        'product' => $_POST['name'],
        'description' => $_POST['description'],
        'category_id' => $category_id,
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
        $_SESSION['error'] = 'Error al actualizar el producto';
        header(header: 'Location: ' . PATH . '/products');
      }
    } else {
      header('Location: ' . PATH . '/products');
    }
  }


  public function delete($id)
  {
    $product_id = implode(", ", $id);
    $this->model->delete($product_id);
    header('Location: ' . PATH . '/products');
  }

}
?>
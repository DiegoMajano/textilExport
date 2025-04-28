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

    $data = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $_POST;
      $this->model->create($product);
      $data['message'] = 'Product created successfully!';
      header('Location: /products');
    } else {
      $data['message'] = 'Error creating product!';
      $this->view('products/create.php', $data);
    }
  }

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $product = $_POST;
      $this->model->update($product);
      header('Location: /products');
    } else {
      $product = $this->model->get($id);
      $this->view('products/edit.php', ['product' => $product]);
    }
  }

  public function delete($id)
  {
    $this->model->delete($id);
    header('Location: /products');
  }

}
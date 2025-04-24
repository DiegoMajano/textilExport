<?php

require_once 'core/Controller.php';
require_once './model/ProductsModel.php';

class ProductsController extends Controller
{

  private $model;

  public function __construct()
  {
    if (empty($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
      header('Location: /products');
      exit;
    }
    $this->model = new ProductsModel();
  }

  public function index()
  {

    $data = [];
    $products = $this->model->get();
    $data['products'] = $products;
    $this->view('products/index', $data);
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
      $this->view('products/create', $data);
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
      $this->view('products/edit', ['product' => $product]);
    }
  }

  public function delete($id)
  {
    $this->model->delete($id);
    header('Location: /products');
  }

}

?>
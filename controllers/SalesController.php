<?php

require_once 'core/Controller.php';
require_once 'model/SalesModel.php';
require_once 'model/SalesDetailsModel.php';

class SalesController extends Controller
{
  private $salesModel;
  private $salesDetailsModel;

  public function __construct()
  {
    if (empty($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    $this->salesModel = new SalesModel();
    $this->salesDetailsModel = new SalesDetailsModel();
  }

  public function index()
  {
    if (empty($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    $user = $_SESSION['user'];
    $sales = $this->salesModel->get();
    $this->view('sales/index', ['sales' => $sales]);
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user_id = $_POST['user_id'];
      $products = $_POST['products'];


      $total = 0;
      foreach ($products as $product) {
        $total += $product['quantity'] * $product['price'];
      }
      $data = [
        'user_id' => $user_id,
        'total' => $total,
        'date' => date('Y-m-d H:i:s'),
        'state' => 1
      ];
      $ventaId = $this->salesModel->add($data);

      foreach ($products as $prod) {
        $data = [
          'sale_id' => $ventaId,
          'product_id' => $prod['id'],
          'quantity' => $prod['quantity'],
          'price' => $prod['price'],
          'state' => 1
        ];
        $this->salesDetailsModel->add($data);
      }

      $this->salesModel->add($data);
      header('Location: /sales');
    } else {
      $this->view('sales/create');
    }
  }

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        'id' => $id,
        'product_id' => $_POST['product_id'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price']
      ];
      $this->salesModel->update($data);
      header('Location: /sales');
    } else {
      $sale = $this->salesModel->get($id);
      $this->view('sales/edit', ['sale' => $sale]);
    }
  }

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->salesModel->delete($id);
      header('Location: /sales');
    } else {
      $sale = $this->salesModel->get($id);
      $this->view('sales/delete', ['sale' => $sale]);
    }
  }

}


?>
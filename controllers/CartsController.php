<?php

require_once 'core/Controller.php';
require_once 'model/CartsModel.php';

class CartsController extends Controller
{
  private $cartsModel;

  public function __construct()
  {
    $this->cartsModel = new CartsModel();
  }

  public function index($user_id)
  {
    $carts = $this->cartsModel->get($user_id);
    $this->view('carts/index', ['carts' => $carts]);
  }

  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        ':user_id' => $_POST['user_id'],
        ':product_id' => $_POST['product_id'],
        ':quantity' => $_POST['quantity'],
        ':state' => 1
      ];
      $this->cartsModel->add($data);
      header('Location: /carts');
    } else {
      $this->view('carts/create');
    }
  }

  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->cartsModel->delete($id);
      header('Location: /carts');
    } else {
      $cart = $this->cartsModel->get($id);
      $this->view('carts/delete', ['cart' => $cart[0] ?? null]);
    }
  }
}

?>
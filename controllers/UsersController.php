<?php

require_once 'core/Controller.php';
require_once 'model/UsersModel.php';
require_once 'core/Validator.php';

class UsersController extends Controller
{
  private $model;

  public function __construct()
  {
    $this->model = new UsersModel();
  }

  public function login()
  {
    $this->view('login.php');
  }

  public function authenticate()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $this->model->login($email, $password);

    if (empty($result)) {
      $viewbag['error'] = 'Usuario y/o contraseña incorrecta';
      $this->view('login.php', $viewbag);
    } else {
      $_SESSION['email'] = $email;
      $_SESSION['user'] = $result[0]['username'];
      $_SESSION['id_role'] = $result[0]['id_role'];
      $_SESSION['role'] = $result[0]['role'];
      echo $_SESSION['role'];
      header('Location: ' . PATH . '/products/index');
      exit;
    }
  }


  public function logout()
  {

    unset($_SESSION['user']);
    unset($_SESSION['role_id']);
    unset($_SESSION['email']);
    $_SESSION = array();
    $this->view('login.php');

  }
}
?>
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
  public function register()
  {
    $this->view('register.php');
  }

  public function authenticate()
  {
    $viewbag = array();
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $result = $this->model->login($email, $password);
    if (empty($result)) {
      $viewbag['error'] = 'Usuario y/o contraseña incorrecta';
      return $this->view('login.php', $viewbag);
    }
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $result[0]['user_id'];
    $_SESSION['user'] = $result[0]['username'];
    $_SESSION['role_id'] = $result[0]['role_id'];
    $_SESSION['role'] = $result[0]['role'];
    header('Location: ' . PATH . '/products/index');
  }

  public function createUser()
  {
    $viewBag = array();

    if (isset($_POST)) {
      $errors = validateRegisterFields($_POST['username'], $_POST['email'], $_POST['password'], $_POST['phone']);
      if (count($errors) > 0) {
        $viewBag['error'] = $errors;
        return $this->view('register.php', $viewBag);
      }
      $user = array(
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'phone' => $_POST['phone'],
        'id_role' => $_POST['id_role'] ?? 2,
        'state' => $_POST['state'] ?? 1
      );

      $success = $this->model->create($user);
      if ($success) {
        $viewBag['success'] = 'Usuario creado correctamente';
        $_SESSION['email'] = $user['email'];
        $_SESSION['user'] = $user['username'];
        return $this->view('login.php', $viewBag);

      } else {
        $viewBag['error'] = 'Error al crear el usuario';
        return $this->view('register.php', $viewBag);
      }

    }
  }

public function update($user_id)
{
    $data = [
        'username' => $_POST['username'],
        'email'    => $_POST['email'],
        'phone'    => $_POST['phone'],
        'id_role'  =>(int) $_POST['id_role'],
        'user_id'  => (int)$user_id,
        'state' => 1
    ];

    $this->model->update($data);
    header("Location: " . PATH . "/users/dashboard");
}

  public function logout()
  {

    unset($_SESSION['user']);
    unset($_SESSION['role_id']);
    unset($_SESSION['email']);
    $_SESSION = array();
    return $this->view('login.php');
  }

  public function delete($user_id)
  {
    $this->model->delete($user_id);
    header("Location: " . PATH . "/users/dashboard");
  }

  public function list(){
    $users = $this->model->get();
    $viewBag = array(
      'users' => $users
    );
    $this->view('manageUsers.php', $viewBag);
  }
}
?>
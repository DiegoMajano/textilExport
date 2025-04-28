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

    public function login(){
        $this->view('login.php');
     }
 
     public function authenticate(){
        $viewbag=array();
        $email = htmlspecialchars(trim($_POST['email']));
        $password = htmlspecialchars(trim($_POST['password']));
        $result=$this->model->login($email);
        if (empty($result) || !password_verify($password, $result[0]['password'])) {
            $viewbag['error'] = 'Usuario y/o contraseña incorrecta';
            return $this->view('login.php', $viewbag);
        }

        $_SESSION['email'] = $email;
        $_SESSION['user'] = $result[0]['username'];
        $_SESSION['role_id'] = $result[0]['role_id'];
        $_SESSION['role'] = $result[0]['role'];
        header('Location: ' . PATH . '/home/index');
     }

     public function register(){
        $viewBag=array();

        if(isset($_POST)){
            $user = array(
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'phone' => $_POST['phone'],
                'id_role' => $_POST['id_role'],
                'state' => $_POST['state']
            );

            $success = $this->model->create($user);
            if ($success) {
                $viewBag['success'] = 'Usuario creado correctamente';
                $_SESSION['email'] = $user['email'];
                $_SESSION['user'] = $user['username'];            
                return $this->view('index.php',$viewBag);
                
            } else {
                $viewBag['error'] = 'Error al crear el usuario';
                return $this->view('register.php', $viewBag);
            }
            
        }
     }
 
     public function logout(){

        unset($_SESSION['user']);
        unset($_SESSION['role_id']);
        unset($_SESSION['email']);
        $_SESSION=array();
        return $this->view('login.php');
    }
}
?>
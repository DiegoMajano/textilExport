<?php 

require_once 'core/Controller.php';

class IndexController extends Controller{
    public function index(){
        header('location: products/'); 
    }

    public function error($params){
        echo 'error 404<br>';
    }
}

?>
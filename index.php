<?php
session_start();

require_once 'controllers/IndexController.php';
require_once 'controllers/CartsController.php';
require_once 'controllers/ProductsController.php';
require_once 'controllers/SalesController.php';
require_once 'controllers/UsersController.php';

const PATH = '/textilExport';


$url = $_SERVER['REQUEST_URI'];
$slices = explode('/', $url);
// echo var_dump($slices).'<br>';

$controller = empty($slices[2]) ? 'IndexController' : $slices[2] . 'Controller';
$method = empty($slices[3]) ? 'index' : $slices[3];
$params = empty($slices[4]) ? [] : array_slice($slices, 4);

$cont = new $controller;
$cont->$method($params);
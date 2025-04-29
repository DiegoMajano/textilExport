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

$controller_part = explode('?', $slices[2])[0] ?? 'IndexController'; // Pa obtener solo la parte antes del '?'
$controller = $controller_part . 'Controller';
$method = empty($slices[3]) ? 'index' : explode('?', $slices[3])[0]; // Pa obtener el método
$params = empty($slices[4]) ? [] : array_map(function ($part) {
  return explode('?', $part)[0];
}, array_slice($slices, 4)); // Esto va a limmpiar parámetros si existen

$cont = new $controller;
$cont->$method($params);
?>
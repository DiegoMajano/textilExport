<?php

require_once 'controllers/IndexController.php';
require_once 'controllers/EditorialesController.php';
require_once 'controllers/AutoresController.php';
require_once 'controllers/GenerosController.php';
require_once 'controllers/LibrosController.php';
const PATH = '/LIS/LIS-Practicas/PracticaMVC';   


$url = $_SERVER['REQUEST_URI'];
$slices=explode('/', $url);
// echo var_dump($slices).'<br>';

$controller = empty($slices[4]) ? 'IndexController' : $slices[4].'Controller';
$method = empty($slices[5]) ? 'index':$slices[5];
$params = empty($slices[6]) ? [] : array_slice($slices, 6);

// echo $url.'<br>';
// echo $slices[4].'<br>';
// echo $controller.'<br>';
// echo $method.'<br>';
// echo var_dump($params);
 
 

$cont = new $controller;
$cont->$method($params);

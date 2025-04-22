<?php

require_once 'controllers/IndexController.php';
const PATH = '/LIS/Desafio2/textilExport';   


$url = $_SERVER['REQUEST_URI'];
$slices=explode('/', $url);
// echo var_dump($slices).'<br>';

$controller = empty($slices[4]) ? 'IndexController' : $slices[4].'Controller';
$method = empty($slices[5]) ? 'index':$slices[5];
$params = empty($slices[6]) ? [] : array_slice($slices, 6);

$cont = new $controller;
$cont->$method($params);

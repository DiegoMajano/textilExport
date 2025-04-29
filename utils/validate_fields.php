<?php

function esPrecioValido($var)
{
  return is_numeric($var);
}
function esExistenciasValidas($var)
{
  return is_numeric($var) && intval($var) == $var && $var >= 0;
}
function esCategoriaValida($var)
{
  $validCategories = ['Cotton', 'Linen', 'Silk', 'Synthetic', 'Wool'];
  return in_array($var, $validCategories, true);
}
function esImagenValida($var)
{
  return preg_match('/\.(jpg|png)$/i', $var) === 1;
}

function esEmailValido($var)
{
  return filter_var($var, FILTER_VALIDATE_EMAIL) !== false;
}
function esTelefonoValido($var)
{
  return preg_match('/^\d{10}$/', $var) === 1;
}

function validateProductFields($name, $description, $category, $price, $stock)
{
  echo "<script>console.log('Validating product fields: Name: $name, Description: $description, Category: $category, Price: $price, Stock: $stock');</script>";
  $errors = [];

  if (empty($name) || empty($description) || empty($category) || !isset($price) || !isset($stock)) {
    array_push($errors, "Todos los campos son obligatorios.");
  } else {

    if (!esPrecioValido($price)) {
      array_push($errors, "El precio no es válido.");
    }
    if (!esExistenciasValidas($stock)) {
      array_push($errors, "Las existencias no son válidas.");
    }
    if (!esCategoriaValida($category)) {
      array_push($errors, "La categoría no es válida.");
    }
  }

  return $errors;
}

function validateRegisterFields($name, $email, $password, $phone)
{
  $errors = [];

  if (empty($name) || empty($email) || empty($password) || empty($phone)) {
    array_push($errors, "Todos los campos son obligatorios.");
  } else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($errors, "El correo electrónico no es válido.");
    }
    if (strlen($password) < 6) {
      array_push($errors, "La contraseña debe tener al menos 6 caracteres.");
    }
    if (!esEmailValido($email)) {
      array_push($errors, "El email es invalido.");
    }
    // if (!esTelefonoValido($phone)) {
    //   array_push($errors, "El telefono es invalido.");
    // }
  }

  return $errors;
}

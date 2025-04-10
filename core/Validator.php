<?php 

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone($phone) {
    return preg_match('/^\+?[267][0-9]{3}-[0-9]{4}$/', $phone);
}

function validateText($var) {
    return preg_match('/^[a-zA-Z áéíóúÁÉÍÓÚ ñ . ,]+$/', $var);
}

function validateId($id) {
    return is_numeric($id) && $id > 0 && intval($id) == $id;
}



?>
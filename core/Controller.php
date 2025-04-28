<?php

abstract class Controller
{

  public function view($view, $data = [])
  {
    $controllerName = str_replace('Controller', '', static::class);
    $filePath = '';

    if ($controllerName === 'Users') {
      $filePath = "views/users/" . $view; // Para UsersController, busca en views/users/
    } else {
      $filePath = "views/" . $view; // Para otros controladores, busca directamente en views/
    }

    if (file_exists($filePath)) {
      extract($data);
      ob_start();
      require_once($filePath);

      $content = ob_get_contents();
      ob_end_clean();
      echo $content;

    } else {
      echo '<h1>View not found: ' . htmlspecialchars($filePath) . '</h1>'; // Muestra la ruta completa para depuración
    }
  }
}
?>
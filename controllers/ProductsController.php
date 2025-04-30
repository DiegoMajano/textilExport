<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'core/Controller.php';
require_once './model/ProductsModel.php';
include_once './utils/validate_fields.php';
require_once __DIR__ . '/../services/cloudinarySDK.php';

class ProductsController extends Controller
{

  private $model;

  public function __construct()
  {
    // if (empty($_SESSION['user'])) {
    //   header('Location: ' . PATH . '/users/login');
    //   exit;
    // }
    $this->model = new ProductsModel();
  }

  public function index()
  {
    $search = $_GET['search'] ?? '';

    if ($search) {
      $products = $this->model->searchByName($search);
    } else {
      $products = $this->model->get();      
    }

    return $this->view('products/index.php', ['products' => $products]);
  }

  public function create()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = validateProductFields($_POST['name'], $_POST['description'], $_POST['category'], $_POST['price'], $_POST['stock']);
    
    // Validar que se haya subido una imagen
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
      $errors[] = 'Debe subir una imagen válida.';
    }

    if (count($errors) > 0) {
      $_SESSION['error'] = $errors;
      $this->view('products/create.php');
      return;
    }

    // Mapear categoría
    $categoryMap = [
      'Cotton' => 1,
      'Linen' => 2,
      'Silk' => 3,
      'Synthetic' => 5,
      'Wool' => 4
    ];
    $category_id = $categoryMap[$_POST['category']] ?? null;

    if ($category_id === null) {
      $_SESSION['error'] = ['Categoría inválida'];
      $this->view('products/create.php');
      return;
    }

    $imageUrl = uploadImage($_FILES['image']);

    if (str_starts_with($imageUrl, 'Error')) {
      $_SESSION['error'] = [$imageUrl];
      $this->view('products/create.php');
      return;
    }

    // Crear producto
    $productData = [
      'product' => $_POST['name'],
      'description' => $_POST['description'],
      'category_id' => $category_id,
      'price' => $_POST['price'],
      'stock' => $_POST['stock'],
      'state' => 1,
      'image_url' => $imageUrl
    ];

    if ($this->model->create($productData)) {
      $_SESSION['success'] = 'Producto creado correctamente';
      header('Location: ' . PATH . '/products');
      exit;
    } else {
      $_SESSION['error'] = ['Error al crear el producto'];
      $this->view('products/create.php');
    }
  } else {
    $this->view('products/create.php');
  }
}



public function edit($id)
{
  // Ya no uses implode para un ID individual
  $product_id = $id;

  require_once __DIR__ . '/../services/cloudinarySDK.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST['price'] = (float) $_POST['price'];
    $_POST['stock'] = (int) $_POST['stock'];
    $errors = validateProductFields($_POST['name'], $_POST['description'], $_POST['category'], $_POST['price'], $_POST['stock']);
    if (count($errors) > 0) {
      $_SESSION['error'] = $errors;
      header('Location: ' . PATH . '/products');
      return;
    }

    $categoryMap = [
      'Cotton' => 1,
      'Linen' => 2,
      'Silk' => 3,
      'Synthetic' => 5,
      'Wool' => 4
    ];

    $category_id = $categoryMap[$_POST['category']] ?? null;

    if ($category_id === null) {
      $_SESSION['error'] = 'Categoría inválida';
      $this->view('products/create.php');
      return;
    }

    $oldImageUrl = $_POST['oldImage'] ?? null;

  if (!$oldImageUrl) {
    $_SESSION['error'] = 'Falta la imagen anterior del producto';
    header('Location: ' . PATH . '/products');
    return;
}

    // Subir nueva imagen si fue proporcionada
    $imageUrl = $oldImageUrl;
    if (!empty($_FILES['image']['tmp_name'])) {
      $uploadResult = uploadImage($_FILES['image'], $oldImageUrl);
      if (str_starts_with($uploadResult, 'http')) {
        $imageUrl = $uploadResult;
      } else {
        $_SESSION['error'] = $uploadResult;
        header('Location: ' . PATH . '/products');
        return;
      }
    }

    $productData = [
      'product_id' => $product_id,
      'product' => $_POST['name'],
      'description' => $_POST['description'],
      'category_id' => $category_id,
      'price' => (float) $_POST['price'],
      'stock' => (int) $_POST['stock'],
      'state' => 1,
      'image_url' => $imageUrl
    ];

    if ($this->model->update($productData)) {
      $_SESSION['success'] = 'Producto actualizado correctamente';
      header('Location: ' . PATH . '/products');
      exit;
    } else {
      $_SESSION['error'] = 'Error al actualizar el producto';
      header('Location: ' . PATH . '/products');
    }
  } else {
    header('Location: ' . PATH . '/products');
  }
}



  public function delete($id)
  {
    //$product_id = implode(", ", $id);
    $this->model->delete($id);
    header('Location: ' . PATH . '/products');
  }

}
?>
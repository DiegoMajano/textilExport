<?php

require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

require_once 'core/Controller.php';
require_once 'model/SalesModel.php';
require_once 'model/SalesDetailsModel.php';
require_once 'model/CartsModel.php';

class SalesController extends Controller
{
  private $salesModel;
  private $salesDetailsModel;
  private $cartsModel;

  public function __construct()
  {
    if (empty($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    $this->salesModel = new SalesModel();
    $this->salesDetailsModel = new SalesDetailsModel();
    $this->cartsModel = new CartsModel();
  }

  public function index()
  {
    if (empty($_SESSION['user'])) {
      header('Location: /login');
      exit;
    }
    $user = $_SESSION['user'];
    $sales = $this->salesModel->get();
    $this->view('sales/index', ['sales' => $sales]);
  }
  public function show($id)
  {
      $sale = $this->salesModel->getByIdWithDetails($id);

      if (!$sale) {
          echo "Compra no encontrada.";
          return;
      }

      include './views/sales/show.php';
  }


  public function create()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user_id = $_POST['user_id'];
        $products = $_POST['products'];

        $total = 0;
        foreach ($products as $product) {
          $total += $product['quantity'] * $product['price'];
        }

        $ventaData = [
          'user_id' => $user_id,
          'total' => $total,
          'date' => date('Y-m-d H:i:s'),
          'state' => 1
        ];
        $ventaId = $this->salesModel->add($ventaData); 

        foreach ($products as $product_id => $prod) {
          $details = [
            'sale_id' => $ventaId,
            'product_id' => $product_id,
            'quantity' => (int)$prod['quantity'],
            'price' => (float)$prod['price'],
            'state' => 1
          ];
          file_put_contents('log.txt', json_encode($details) . PHP_EOL, FILE_APPEND);

          $result = $this->salesDetailsModel->add($details);
          file_put_contents("log_details_add.txt", "Resultado: " . var_export($result, true) . PHP_EOL, FILE_APPEND);
        }

        $this->cartsModel->clearCart($user_id);

        header('Location: ' . PATH . '/sales/show/' . $ventaId);
    } else {
        $this->view('sales/create');
    }
  }

  public function pdf($sale_id)
  {
    $sale = $this->salesModel->getByIdWithDetails($sale_id);
    if (!$sale) {
        die("Venta no encontrada.");
    }

    ob_start();
    include 'views/sales/pdf_template.php'; // crea esta vista
    $html = ob_get_clean();

    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $filename = "venta_" . $sale['sale_id'] . ".pdf";
    $dompdf->stream($filename, ['Attachment' => true]); // descarga directa
  }



  public function edit($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        'id' => $id,
        'product_id' => $_POST['product_id'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price']
      ];
      $this->salesModel->update($data);
      header('Location: /sales');
    } else {
      $sale = $this->salesModel->get($id);
      $this->view('sales/edit', ['sale' => $sale]);
    }
  }

  public function delete($id)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $this->salesModel->delete($id);
      header('Location: /sales');
    } else {
      $sale = $this->salesModel->get($id);
      $this->view('sales/delete', ['sale' => $sale]);
    }
  }

}


?>
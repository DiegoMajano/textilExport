<?php 

require_once 'core/Controller.php';
require_once 'model/SalesModel.php';
require_once 'model/UsersModel.php';

class DashboardController extends Controller
{
    private $userModel;
    private $salesModel;

    public function __construct()
    {
        $this->userModel = new UsersModel();
        $this->salesModel = new SalesModel();
    }

    public function index()
    {
        $viewBag = array(
            'totalUsers' => $this->userModel->getTotalUsers(),
            'totalSales' => $this->salesModel->getTotalSales(),
            'totalRevenue' => $this->salesModel->getTotalRevenue(),
            'recentSales' => $this->salesModel->getRecentSales()
        );

        $this->view('users/dashboard.php', $viewBag);
    }

}



?>
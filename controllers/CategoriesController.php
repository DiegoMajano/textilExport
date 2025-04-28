<?php

require_once 'core/Controller.php';
require_once 'model/CategoriesModel.php';

class CategoriesController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new CategoriesModel();
    }

    public function index()
    {
        $viewBag['categories'] = $this->model->get();
        $this->view('categories/index.php', $viewBag);
    }

    public function create()
    {
        if (isset($_POST)) {
            $category = [
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'state' => $_POST['state']
            ];

            $this->model->create($category);
            header('Location: ' . PATH . '/categories/index');
            exit;
        }

        $this->view('categories/create.php');
    }

    public function edit($id)
    {
        if (isset($_POST)) {
            $category = [
                'category' => $_POST['category'],
                'description' => $_POST['description'],
                'state' => $_POST['state']
            ];

            $this->model->update($id, $category);
            header('Location: ' . PATH . '/categories/index');
            exit;
        }

        $viewBag['category'] = $this->model->get($id)[0];
        $this->view('categories/edit.php', $viewBag);
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: ' . PATH . '/categories/index');
        exit;
    }
}

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
        $category = $this->model->getById($id);
        if (!$category) {
            echo "Categoría no encontrada";
            return;
        }
        $this->view('categories/edit.php', ['category' => $category]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $category = trim($_POST['category']); 
            $description = trim($_POST['description']);
            $state = 1;
            

            $updated = $this->model->update($id, [
                'category' => $category,
                'description' => $description,
                'state' => $state
            ]);

            if ($updated) {
                $_SESSION['success_message'] = 'Categoría actualizada correctamente.';
                header('Location: ' . PATH . '/categories/index');
                exit;
            } else {
                $this->view('categories/edit.php', ['category' => ['id' => $id, 'category' => $category], 'error' => 'Error al actualizar']);
            }
        }
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header('Location: ' . PATH . '/categories/index');
        exit;
    }
}

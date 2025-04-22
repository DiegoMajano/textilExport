<?php 

require_once '../core/Model.php';

class SalesModel extends Model {
    public function get($id = null) {
        if ($id) {
            $query = "SELECT * FROM sales WHERE id = :id";
            return $this->getQuery($query, [':id' => $id]);
        } else {
            $query = "SELECT * FROM sales";
            return $this->getQuery($query);
        }
    }

    public function add($data) {
        $query = "INSERT INTO sales (product_id, quantity, price) VALUES (:product_id, :quantity, :price)";
        return $this->setQuery($query, $data);
    }

    public function update($data) {
        $query = "UPDATE sales SET product_id = :product_id, quantity = :quantity, price = :price WHERE id = :id";
        return $this->setQuery($query, $data);
    }

    public function delete($id) {
        $query = "DELETE FROM sales WHERE id = :id";
        return $this->setQuery($query, [':id' => $id]);
    }
}


?>
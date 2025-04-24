<?php

require_once './core/Model.php';

class SalesDetailsModel extends Model
{
  public function get($id = null)
  {
    if ($id) {
      $query = "SELECT * FROM sales_details WHERE id = :id";
      return $this->getQuery($query, [':id' => $id]);
    } else {
      $query = "SELECT * FROM sales_details";
      return $this->getQuery($query);
    }
  }

  public function add($data)
  {
    $query = "INSERT INTO sales_details (sale_id, product_id, quantity, price, state) VALUES (:sale_id, :product_id, :quantity, :price, :state)";
    return $this->setQuery($query, $data);
  }

  public function update($data)
  {
    $query = "UPDATE sales_details SET sale_id = :sale_id, product_id = :product_id, quantity = :quantity, price = :price WHERE id = :id";
    return $this->setQuery($query, $data);
  }

  public function delete($id)
  {
    $query = "DELETE FROM sales_details WHERE id = :id";
    return $this->setQuery($query, [':id' => $id]);
  }
}

?>
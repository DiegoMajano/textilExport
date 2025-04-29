<?php

require_once './core/Model.php';

class SalesDetailsModel extends Model
{
  public function get($id = null)
  {
    if ($id) {
      $query = "SELECT * FROM sale_detail WHERE id = :id";
      return $this->getQuery($query, [':id' => $id]);
    } else {
      $query = "SELECT * FROM sale_detail";
      return $this->getQuery($query);
    }
  }

  public function add($data)
  {
    $query = "INSERT INTO sale_detail (sale_id, product_id, quantity, price, state) VALUES (:sale_id, :product_id, :quantity, :price, :state)";

    file_put_contents('log_model.txt', json_encode($data) . PHP_EOL, FILE_APPEND);  // Log en el modelo

    return $this->setQuery($query, $data);
  }

  public function update($data)
  {
    $query = "UPDATE sale_detail SET sale_id = :sale_id, product_id = :product_id, quantity = :quantity, price = :price WHERE id = :id";
    return $this->setQuery($query, $data);
  }

    public function delete($id) {
        $query = "UPDATE sale_detail SET state = :state WHERE id = :id";
        return $this->setQuery($query, [':id' => $id, ':state' => 0]);
    }
}

?>
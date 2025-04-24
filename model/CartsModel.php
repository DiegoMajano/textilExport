<?php

require_once './core/Model.php';

class CartsModel extends Model
{
  public function get($id = null)
  {
    if ($id) {
      $query = "SELECT * FROM carts INNER JOIN users on carts.user_id = users.user_id WHERE id = :id";
      return $this->getQuery($query, [':id' => $id]);
    } else {
      $query = "SELECT * FROM carts";
      return $this->getQuery($query);
    }
  }

  public function add($data)
  {
    $query = "INSERT INTO carts (user_id, product_id, quantity, state) VALUES (:user_id, :product_id, :quantity, :state)";
    return $this->setQuery($query, $data);
  }

  public function update($data)
  {
    $query = "UPDATE carts SET user_id = :user_id, product_id = :product_id, quantity = :quantity, state = :state WHERE id = :id";
    return $this->setQuery($query, $data);
  }

  public function delete($id)
  {
    $query = "UPDATE carts set state = :state  WHERE id = :id";
    return $this->setQuery($query, [':id' => $id, ':state' => 0]);
  }
}


?>
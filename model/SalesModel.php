<?php

require_once './core/Model.php';

class SalesModel extends Model
{
  public function get($id = null)
  {
    if ($id) {
      $query = "SELECT * FROM sales WHERE id = :id";
      return $this->getQuery($query, [':id' => $id]);
    } else {
      $query = "SELECT * FROM sales";
      return $this->getQuery($query);
    }
  }

  public function add($data)
  {
    $query = "INSERT INTO sales (user_id, total, date, state) VALUES (:user_id, :total, :date, :state)";
    return $this->setQuery($query, $data);
  }

  public function update($data)
  {
    $query = "UPDATE sales SET user_id = :user_id, total = :total, date = :date, state = :state WHERE id = :id";
    return $this->setQuery($query, $data);
  }

    public function delete($id) {
        $query = "UPDATE sales SET state = :state  WHERE id = :id";
        return $this->setQuery($query, [':id' => $id, ':state' => 0]);
    }
}


?>
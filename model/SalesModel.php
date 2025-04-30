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
      try {
        $this->openDB();

        $query = "INSERT INTO sales (user_id, total, date, state)
                  VALUES (:user_id, :total, :date, :state)";

        $stmt = $this->conn->prepare($query);
        $stmt->execute($data);

        $lastId = $this->conn->lastInsertId();

        $this->closeDB();
        return $lastId;

    } catch (PDOException $e) {
        $this->closeDB();
        echo $e->getMessage();
    }
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

  public function getByIdWithDetails($sale_id)
  {
      $query = "SELECT s.*, u.username, u.email, u.phone
                FROM sales s
                JOIN users u ON s.user_id = u.user_id
                WHERE s.sale_id = :sale_id";
      $result = $this->getQuery($query, ['sale_id' => $sale_id]);

      if (!$result || count($result) === 0) return null;

      $sale = $result[0]; // Solo una venta

      $detailsQuery = "SELECT sd.*, p.product
                      FROM sale_detail sd
                      JOIN products p ON sd.product_id = p.product_id
                      WHERE sd.sale_id = :sale_id";
      $details = $this->getQuery($detailsQuery, ['sale_id' => $sale_id]);
      $sale['details'] = $details;
      return $sale;
  }


  public function getTotalSales()
  {
      $query = "SELECT COUNT(*) AS total FROM sales";
      $result = $this->getQuery($query);
      return $result[0]['total'];
  }

  public function getTotalRevenue()
  {
      $query = "SELECT SUM(total) AS revenue FROM sales";
      $result = $this->getQuery($query);
      return $result[0]['revenue'];
  }

  public function getRecentSales()
  {
      $query = "SELECT * FROM sales ORDER BY date DESC LIMIT 5";
      return $this->getQuery($query);
  }

  public function getAllSalesWithUser()
  {
    $query = "SELECT s.*, u.username 
              FROM sales s 
              JOIN users u ON s.user_id = u.user_id 
              ORDER BY s.date DESC";
    return $this->getQuery($query);
  }


}


?>
<?php
abstract class Model
{
  private $host = 'localhost';
  private $user = 'root';
  private $password = '';
  private $dbName = 'textilexport';
  protected $conn;

  protected function openDB()
  {
    try {
      $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName;charset=utf8", username: $this->user, password: $this->password);
    } catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  protected function closeDB()
  {
    $this->conn = null;
  }

  protected function getQuery($query, $params = array())
  {

    try {
      $this->openDB();

      $stm = $this->conn->prepare($query);
      $stm->execute($params);

      while ($rows[] = $stm->fetch(PDO::FETCH_ASSOC))
        ;
      $this->closeDB();
      array_pop($rows);
      return $rows;
    } catch (PDOException $e) {
      $this->closeDB();
      echo $e->getMessage();
    }
  }

  protected function setQuery($query, $params = array())
  {

    try {
      $this->openDB();

      $stmt = $this->conn->prepare($query);
      $stmt->execute($params);

      $affectedRows = $stmt->rowCount();
      $this->closeDB();
      return $affectedRows;
    } catch (Exception $e) {
      $this->closeDB();
      echo $e->getMessage();
    }
  }
}
<?php

require_once 'core/Model.php';
require_once 'core/Validator.php';

class UsersModel extends Model
{
  public function get($id = null)
  {
    if ($id) {
      $query = "SELECT * FROM users WHERE id = :id";
      return $this->getQuery($query, [':id' => $id]);
    } else {
      $query = "SELECT * FROM users";
      return $this->getQuery($query);
    }
  }

  public function login($email, $password)
  {
    $query = "SELECT id_role, username, role 
              FROM users 
              INNER JOIN roles ON users.id_role = roles.role_id 
              WHERE email = :email AND password = :password 
              LIMIT 1";

    $result = $this->getQuery($query, [
      ':email' => $email,
      ':password' => $password
    ]);

    return $result;
  }

  public function create($user)
  {
    $query = "INSERT INTO users (username, email, password, phone, id_role, state) VALUES (:username, :email, :password, :phone, :id_role, :state)";
    return $this->setQuery($query, $user);
  }

  public function update($user)
  {
    $query = "UPDATE users SET username = :username, email = :email, phone = :phone, id_role = :id_role, state = :state WHERE id = :id";
    return $this->setQuery($query, $user);
  }

  public function delete($id)
  {
    $query = "UPDATE users SET state = :state WHERE id = :id";
    return $this->setQuery($query, [':id' => $id]);
  }

  public function findByEmail($email)
  {
    $query = "SELECT * FROM users WHERE email = :email";
    return $this->getQuery($query, [':email' => $email]);
  }

  public function getByRole($roleId)
  {
    $query = "SELECT * FROM users WHERE role_id = :role_id AND state = 1";
    return $this->getQuery($query, [':role_id' => $roleId]);
  }

  public function search($keyword)
  {
    $query = "SELECT * FROM users WHERE username LIKE :keyword OR email LIKE :keyword";
    return $this->getQuery($query, [':keyword' => "%$keyword%"]);
  }

  public function getActiveUsers()
  {
    $query = "SELECT * FROM users WHERE state = 1";
    return $this->getQuery($query);
  }

  public function countUsers()
  {
    $query = "SELECT COUNT(*) as total FROM users WHERE state = 1";
    return $this->getQuery($query)[0]['total'];
  }

  public function countByRole()
  {
    $query = "SELECT roles.role, COUNT(*) as total FROM users 
                INNER JOIN roles ON users.role_id = roles.role_id 
                WHERE users.state = 1 
                GROUP BY users.role_id";
    return $this->getQuery($query);
  }




}
?>
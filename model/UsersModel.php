<?php

require_once 'core/Model.php';
require_once 'core/Validator.php';

class UsersModel extends Model
{
  public function get($id = null)
  {
    if ($id) {
      $query = "SELECT * FROM users WHERE id = :id and state = 1";
      return $this->getQuery($query, [':id' => $id]);
    } else {
      $query = "SELECT * FROM users INNER JOIN roles on users.id_role = role_id where users.state = 1";
      return $this->getQuery($query);
    }
  }

  public function login($email)
{
  $query = "SELECT id_role, username, role, user_id, password 
            FROM users 
            INNER JOIN roles ON users.id_role = roles.role_id 
            WHERE email = :email 
            AND users.state = 1
            LIMIT 1";

  $result = $this->getQuery($query, [':email' => $email]);

  return $result;
}


  public function create($user)
  {
    $query = "INSERT INTO users (username, email, password, phone, id_role, state) VALUES (:username, :email, :password, :phone, :id_role, :state)";
    return $this->setQuery($query, $user);
  }

  public function update($user)
  {
    $query = "UPDATE users SET username = :username, email = :email, phone = :phone, id_role = :id_role, state = :state WHERE user_id = :user_id";
    return $this->setQuery($query, $user);
  }

  public function delete($user_id)
  {
    $query = "UPDATE users SET state = :state WHERE user_id = :user_id";
    return $this->setQuery($query, [':user_id' => $user_id, ':state' => '0']);
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

  
  public function getTotalUsers()
  {
      $query = "SELECT COUNT(*) AS total FROM users where state = 1";
      $result = $this->getQuery($query);
      return $result[0]['total'];
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
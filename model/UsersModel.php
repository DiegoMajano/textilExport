<?php 

require_once 'core/Model.php';
require_once 'core/Validator.php';

class UsersModel extends Model
{
    public function getUsers($id=null)
    {
        if ($id) {
            $query = "SELECT * FROM users";
            return $this->getQuery($query);
        } else {    
            $query = "SELECT * FROM users WHERE id = :id";
            return $this->getQuery($query, [':id' => $id]);
        }
    }

    public function login($email, $password)
    {
        $query = "SELECT id_role, username, role FROM users INNER JOIN roles on users.role_id = roles.role_id WHERE email = :email AND password = SHA2(:password,256)";
        return $this->getQuery($query, [':email' => $email, ':password' => $password]);
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
        $query = "DELETE FROM users WHERE id = :id";
        return $this->setQuery($query, [':id' => $id]);
    }

}
?>
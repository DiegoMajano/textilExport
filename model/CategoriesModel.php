<?php

require_once 'core/Model.php';

class CategoriesModel extends Model
{
    public function get($id=null)
    {
        if ($id) {
            $query = "SELECT * FROM categories WHERE category_id = :id AND state = '1' ORDER BY category_id ASC";
            return $this->getQuery($query, [':id' => $id]);
        } else {    
            $query = "SELECT * FROM categories where state = '1' ORDER BY category_id ASC";
            return $this->getQuery($query);
        }
    }

    public function getById($id)
    {
        $query = "SELECT * FROM categories WHERE id = :id";
        $params = [':id' => $id];
        return $this->getQuery($query, $params);
    }


    public function create($data)
    {
        $query = "INSERT INTO categories (category, description, state) VALUES (:category, :description, :state)";
        return $this->setQuery($query, [
            ':category' => $data['category'],
            ':description' => $data['description'],
            ':state' => $data['state']
        ]);
    }

    public function update($category_id, $data)
    {
        $query = "UPDATE categories SET category = :category, description = :description, state = :state WHERE category_id = :category_id";
        return $this->setQuery($query, [
            ':category' => $data['category'],
            ':description' => $data['description'],
            ':state' => $data['state'],
            ':category_id' => $category_id
        ]);
    }

    public function delete($id)
    {
        $query = "UPDATE categories set state = :state WHERE category_id = :id";
        return $this->setQuery($query, [':id' => $id, ':state' => 0]);
    }
}


?>
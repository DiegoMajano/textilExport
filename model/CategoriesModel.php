<?php

require_once 'core/Model.php';

class CategoriesModel extends Model
{
    public function get($id=null)
    {
        if ($id) {
            $query = "SELECT * FROM categories WHERE category_id = :id";
            return $this->getQuery($query, [':id' => $id]);
        } else {    
            $query = "SELECT * FROM categories";
            return $this->getQuery($query);
        }
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

    public function update($id, $data)
    {
        $query = "UPDATE categories SET category = :category, description = :description, state = :state WHERE category_id = :id";
        return $this->setQuery($query, [
            ':category' => $data['category'],
            ':description' => $data['description'],
            ':state' => $data['state'],
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        $query = "UPDATE categories set state = :state WHERE category_id = :id";
        return $this->setQuery($query, [':id' => $id, ':state' => 0]);
    }
}


?>
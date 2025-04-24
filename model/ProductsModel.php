<?php 

require_once '/../core/Model.php';

class ProductsModel extends Model {

    public function get($id=null)
    {
        if ($id) {
            $query = "SELECT * FROM products WHERE id = :id";
            return $this->getQuery($query);
        } else {    
            $query = "SELECT * FROM products";
            return $this->getQuery($query, [':id' => $id]);
        }
    }

    public function create($product)
    {
        $query = "INSERT INTO products (product, description, image_url, category_id, price, stock, state) VALUES (:product, :description, :image_url, :category_id, :price, :stock, :state)";
        return $this->setQuery($query, $product);
    }

    public function update($product)
    {
        $query = "UPDATE products SET product = :product, description = :description, image_url = :image_url, category_id = :category_id, price = :price, stock = :stock, state = :state WHERE id = :id";
        return $this->setQuery($query, $product);
    }

    public function delete($id)
    {
        $query = "DELETE products SET state = :state WHERE id = :id";
        return $this->setQuery($query, [':id' => $id, ':state' => 0]);
    }

    public function searchByName($name)
    {
        $query = "SELECT * FROM products WHERE product LIKE :name";
        return $this->getQuery($query, [':name' => '%' . $name . '%']);
    }

    public function getByCategory($categoryId)
    {
        $query = "SELECT * FROM products WHERE category_id = :category_id AND state = 1";
        return $this->getQuery($query, [':category_id' => $categoryId]);
    }

    public function getLowStock($threshold = 10)
    {
        $query = "SELECT * FROM products WHERE stock <= :threshold AND state = 1";
        return $this->getQuery($query, [':threshold' => $threshold]);
    }

}


?>
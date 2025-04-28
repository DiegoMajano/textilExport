<?php

require_once './core/Model.php';

class ProductsModel extends Model
{

  public function get($product_id = null)
  {
    if ($product_id) {
      $query = "SELECT p.*, c.category 
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_id = :product_id";
      return $this->getQuery($query, [':product_id' => $product_id]);
    } else {
      $query = "SELECT p.*, c.category
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.category_id";
      return $this->getQuery($query);
    }

  public function create($product)
  {
    $query = "INSERT INTO products (product, description, image_url, category_id, price, stock, state) VALUES (:product, :description, :image_url, :category_id, :price, :stock, :state)";
    return $this->setQuery($query, $product);
  }

  public function update($product)
  {
    $query = "UPDATE products SET product = :product, description = :description, image_url = :image_url, category_id = :category_id, price = :price, stock = :stock, state = :state WHERE product_id = :product_id"; // Usar product_id
    return $this->setQuery($query, $product);
  }

    public function delete($product_id)
    {
        $query = "UPDATE products SET state = :state WHERE product_id = :product_id";
        return $this->setQuery($query, [':product_id' => $product_id, ':state' => 0]);
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
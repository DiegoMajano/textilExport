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
                  WHERE p.product_id = :product_id AND p.state = 1";
      return $this->getQuery($query, [':product_id' => $product_id]);
    } else {
      $query = "SELECT p.*, c.category
                  FROM products p
                  LEFT JOIN categories c ON p.category_id = c.category_id
                  WHERE p.state = 1";
      return $this->getQuery($query);
    }
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

  public function getStock($product_id)
{
  $query = "SELECT stock FROM products WHERE product_id = :product_id";
  $result = $this->getQuery($query, [':product_id' => $product_id]);
  return $result[0]['stock'] ?? 0;
}

public function decreaseStock($product_id, $quantity)
{
  $query = "UPDATE products SET stock = stock - :quantity WHERE product_id = :product_id AND stock >= :quantity";
  return $this->setQuery($query, [
    ':product_id' => $product_id,
    ':quantity' => $quantity
  ]);
}

}
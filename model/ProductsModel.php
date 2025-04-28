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

  public function delete($product_id) // Cambiar el nombre del parámetro
  {
    $query = "DELETE FROM products WHERE product_id = :product_id"; // Usar product_id
    return $this->setQuery($query, [':product_id' => $product_id]);
  }

}
<?php

require_once './core/Model.php';

class CartsModel extends Model {

    public function get($id) {
        $query = "SELECT * FROM carts INNER JOIN users ON carts.user_id = users.user_id WHERE id = :id";
        return $this->getQuery($query, [':id' => $id]);
    }

    public function getByUser($userId) {
        $query = "SELECT carts.*, products.product, products.price, products.image_url
                  FROM carts
                  INNER JOIN products ON carts.product_id = products.id
                  WHERE carts.user_id = :user_id AND carts.state = 1";
        return $this->getQuery($query, [':user_id' => $userId]);
    }

    public function add($data) {
        $query = "INSERT INTO carts (user_id, product_id, quantity, state)
                  VALUES (:user_id, :product_id, :quantity, :state)";
        return $this->setQuery($query, $data);
    }

    public function update($data) {
        $query = "UPDATE carts SET user_id = :user_id, product_id = :product_id, quantity = :quantity, state = :state
                  WHERE id = :id";
        return $this->setQuery($query, $data);
    }

    public function delete($id) {
        $query = "UPDATE carts SET state = 0 WHERE id = :id";
        return $this->setQuery($query, [':id' => $id]);
    }

    public function clearCart($userId) {
        $query = "UPDATE carts SET state = 0 WHERE user_id = :user_id";
        return $this->setQuery($query, [':user_id' => $userId]);
    }
}

?>

<?php
// app/models/Product.php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db =  new database();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products ORDER BY created_at DESC";
        return $this->db->runQuery($query);
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->runQuery($sql, [$id]);
    
        // Nếu $stmt là một đối tượng PDOStatement, gọi fetch()
        if ($stmt instanceof PDOStatement) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        return false; // Trả về false nếu không tìm thấy sản phẩm
    }
    public function getRelatedProducts($category_id, $exclude_id) {
        $sql = "SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4";
        $stmt = $this->db->runQuery($sql, [$category_id, $exclude_id]);
    
        // Nếu $stmt là một đối tượng PDOStatement, gọi fetchAll()
        if ($stmt instanceof PDOStatement) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        return []; // Trả về mảng rỗng nếu không tìm thấy sản phẩm liên quan
    }
    
    

    public function createProduct($name, $price, $description, $image, $quantity, $category_id) {
        $sql = "INSERT INTO products (name, price, description, image, quantity, category_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->runQuery($sql, [$name, $price, $description, $image, $quantity, $category_id]);
    }

    public function updateProduct($id, $name, $price, $description, $image, $quantity, $category_id) {
        $sql = "UPDATE products SET name = ?, price = ?, description = ?, image = ?, quantity = ?, category_id = ? WHERE id = ?";
        return $this->db->runQuery($sql, [$name, $price, $description, $image, $quantity, $category_id, $id]);
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = ?";
        return $this->db->runQuery($sql, [$id]);
    }
}
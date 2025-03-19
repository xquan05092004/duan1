<?php
class Product{
    private $db;
    
    public function __construct($db){
        $this->db = $db;
    }
    public function getAllProducts(){
        $stmt = $this-> db ->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductById($id){
        $stmt = $this-> db ->prepare("SELECT * FROM products WHERE id =?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
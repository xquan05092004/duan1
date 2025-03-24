<?php
    class Categories{
        private $db;

        public function __construct()
        {
            $this->db =  new database();
        }
        public function getAllCategories(){
            return $this->db->runQuery("SELECT * FROM categories")->fetchAll();
        }
        
        public function addCategories($name) {
            $sql = "INSERT INTO categories (name) VALUES (?)";
            return $this->db->runQuery($sql, [$name]);
        }
        public function updateCategories($id, $name) {
            $query = "UPDATE categories SET name = ? WHERE id = ?";
            return $this->db->runQuery($query, [$name, $id]);
        }
                
        public function deleteCategories($id) {
            $sql = "DELETE FROM categories WHERE id = ?";
            return $this->db->runQuery($sql, [$id]);
        }
              
        public function getCategoriesById($id) {
            $query = "SELECT * FROM categories WHERE id = ?";
            $stmt = $this->db->runQuery($query, [$id]);
        
            if ($stmt) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return null;
            }
        }
        
        
        
        
        
        
        
}
?>
<?php
require_once __DIR__ . '/../config/database.php';
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
            // Kiểm tra xem có sản phẩm nào thuộc danh mục không
            $checkSql = "SELECT COUNT(*) as total FROM products WHERE category_id = ?";
            $stmt = $this->db->runQuery($checkSql, [$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            if ($result && $result['total'] > 0) {
                // Có sản phẩm liên kết -> không xóa
                return [
                    'success' => false,
                    'message' => 'Danh mục có sản phẩm, không thể xóa.'
                ];
            }
        
            // Thực hiện xóa nếu không có sản phẩm nào
            $deleteSql = "DELETE FROM categories WHERE id = ?";
            $deleteStmt = $this->db->runQuery($deleteSql, [$id]);
        
            if ($deleteStmt) {
                return [
                    'success' => true,
                    'message' => 'Xóa danh mục thành công.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Lỗi khi xóa danh mục!'
                ];
            }
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
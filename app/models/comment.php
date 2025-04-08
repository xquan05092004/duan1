<?php 
require_once __DIR__ . '/../config/database.php';

class Comment {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Lấy tất cả bình luận, có thể lọc theo trạng thái
    public function getAllComments($status = null) {
        $sql = "SELECT c.*, u.name AS user_name, p.name AS product_name
                FROM comments c
                JOIN users u ON c.user_id = u.id
                JOIN products p ON c.product_id = p.id ";
        
        if ($status) {
            $sql .= "WHERE c.status = :status";
        }

        $stmt = $this->db->getConnection()->prepare($sql);

        if ($status) {
            $stmt->bindParam(':status', $status);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái bình luận
    public function updateComment($id, $status){
        $stmt = $this->db->getConnection()->prepare("UPDATE comments SET status = :status WHERE id = :id");
    
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
        $success = $stmt->execute();
    
        if (!$success) {
            print_r($stmt->errorInfo()); // Kiểm tra lỗi SQL
            exit;
        }
    
        return $success;
    }
    
    // Xóa bình luận
    public function delete($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>

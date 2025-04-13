<?php
require_once __DIR__ . '/../config/database.php';

class Comment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function create($user_id, $product_id, $content)
    {
        $sql = "INSERT INTO comments (user_id, product_id, content, status, created_at)
            VALUES (:user_id, :product_id, :content, 'pending', NOW())";

        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        return $stmt->execute();
    }
    public function getCommentsByProductId($product_id)
    {
        $sql = "SELECT c.*, u.name AS user_name 
            FROM comments c 
            JOIN users u ON c.user_id = u.id 
            WHERE c.product_id = :product_id AND c.status = 'pending' 
            ORDER BY c.created_at DESC";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy tất cả bình luận, có thể lọc theo trạng thái
    public function getAllComments($status = null)
    {
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
    public function updateComment($id, $status)
    {
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
    public function delete($id)
    {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}

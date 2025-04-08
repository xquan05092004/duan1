<?php
require_once __DIR__ . '/../config/database.php';

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Đảm bảo class Database có phương thức getConnection()
    }

    public function getOrders($status = null) {
        if (!$this->db) {
            die("Lỗi: Không có kết nối database!");
        }

        $query = "SELECT * FROM orders";
        if ($status !== null) {
            $query .= " WHERE status = :status";
        }

        $stmt = $this->db->getConnection()->prepare($query); // Gọi kết nối từ class Database

        if ($status !== null) {
            $stmt->bindParam(':status', $status);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatusOrder($id, $status) {
        if (!$this->db) {
            die("Lỗi: Không có kết nối database!");
        }

        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($query);

        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}
?>

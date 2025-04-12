<?php
require_once __DIR__ . '/../config/database.php';

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); // Đảm bảo class Database có phương thức getConnection()
    }
    public function getOrderDetailsById($orderId) {
        $sql = "SELECT oi.*, p.name AS product_name, p.image AS product_image
                FROM order_items oi
                JOIN product_variants pv ON oi.product_variant_id = pv.id
                JOIN products p ON pv.product_id = p.id
                WHERE oi.order_id = ?";
        return $this->db->runQuery($sql, [$orderId])->fetchAll();
    }
    
    
    public function getOrderInfo($orderId) {
        $sql = "SELECT o.*, u.name AS customer_name, u.email, u.phone
                FROM orders o
                JOIN users u ON o.user_id = u.id
                WHERE o.id = ?";
        return $this->db->runQuery($sql, [$orderId])->fetch();
    }
    
    public function getOrders($status = null)
    {
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
    public function getOrderById($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->runQuery($sql, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatusOrder($id, $status)
    {
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

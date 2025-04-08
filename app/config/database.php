<?php
class database {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=clothing_store;charset=utf8", "root", "");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Lỗi kết nối DB: " . $e->getMessage());
        }
    }

    public function runQuery($query, $params = []) {
        $stmt = $this->pdo->prepare($query);  // Chuẩn bị truy vấn
        $stmt->execute($params);              // Thực thi với tham số
        return $stmt;                         // Trả về đối tượng Statement
    }
    public function getConnection() {
        return $this->pdo;
    }
    
}

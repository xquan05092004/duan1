<?php

// app/models/ProductVariant.php
require_once __DIR__ . '/../config/database.php';

class ProductVariant
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public static function find($id)
    {
        if (!$id) return null;
        $db = new Database();
        $query = "SELECT pv.*, p.name as product_name, s.name as size_name, c.color_code as color_name 
                  FROM product_variants pv
                  JOIN products p ON p.id = pv.product_id
                  JOIN sizes s ON s.id = pv.size_id
                  JOIN colors c ON c.id = pv.color_id
                  WHERE pv.id = :id LIMIT 1";
        $stmt = $db->runQuery($query, [':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByProductId($product_id)
    {
        $query = "
            SELECT pv.*, s.name AS size_name, c.color_code AS color_name
            FROM product_variants pv
            JOIN sizes s ON pv.size_id = s.id
            JOIN colors c ON pv.color_id = c.id
            WHERE pv.product_id = :product_id
        ";
        $stmt = $this->db->runQuery($query, [':product_id' => $product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exists($product_id, $size_id, $color_id)
    {
        $query = "SELECT COUNT(*) as count FROM product_variants 
                 WHERE product_id = :product_id 
                 AND size_id = :size_id 
                 AND color_id = :color_id";
        $stmt = $this->db->runQuery($query, [
            ':product_id' => $product_id,
            ':size_id' => $size_id,
            ':color_id' => $color_id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    public function validate($data)
    {
        $errors = [];

        if (empty($data['product_id'])) {
            $errors[] = "Sản phẩm không được để trống";
        }
        if (empty($data['size_id'])) {
            $errors[] = "Size không được để trống";
        }
        if (empty($data['color_id'])) {
            $errors[] = "Màu sắc không được để trống";
        }

        return $errors;
    }

    public function searchVariants($filters = [])
    {
        $query = "
            SELECT pv.*, s.name AS size_name, c.color_code AS color_name
            FROM product_variants pv
            JOIN sizes s ON pv.size_id = s.id
            JOIN colors c ON pv.color_id = c.id
            WHERE 1=1
        ";
        $params = [];

        if (!empty($filters['product_id'])) {
            $query .= " AND pv.product_id = :product_id";
            $params[':product_id'] = $filters['product_id'];
        }
        if (!empty($filters['color_id'])) {
            $query .= " AND pv.color_id = :color_id";
            $params[':color_id'] = $filters['color_id'];
        }
        if (!empty($filters['size_id'])) {
            $query .= " AND pv.size_id = :size_id";
            $params[':size_id'] = $filters['size_id'];
        }

        $stmt = $this->db->runQuery($query, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllWithDetails()
    {
        $query = "SELECT 
                p.id AS product_id, 
                p.name AS product_name,
                GROUP_CONCAT(DISTINCT s.name ORDER BY s.name ASC) AS sizes,
                GROUP_CONCAT(DISTINCT c.color_code ORDER BY c.color_code ASC) AS colors,
                COUNT(DISTINCT pv.size_id) AS size_count,
                COUNT(DISTINCT pv.color_id) AS color_count
            FROM products p
            LEFT JOIN product_variants pv ON p.id = pv.product_id
            LEFT JOIN sizes s ON pv.size_id = s.id
            LEFT JOIN colors c ON pv.color_id = c.id
            GROUP BY p.id, p.name";

        $stmt = $this->db->runQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $errors = $this->validate($data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $this->db->beginTransaction();
        try {
            foreach ($data['size_id'] as $size_id) {
                foreach ($data['color_id'] as $color_id) {
                    if (!$this->exists($data['product_id'], $size_id, $color_id)) {
                        $query = "INSERT INTO product_variants (product_id, size_id, color_id) 
                                VALUES (:product_id, :size_id, :color_id)";
                        $this->db->runQuery($query, [
                            ':product_id' => $data['product_id'],
                            ':size_id' => $size_id,
                            ':color_id' => $color_id
                        ]);
                    }
                }
            }

            $this->db->commit();
            return ['success' => true];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Create error: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Lỗi khi tạo biến thể sản phẩm']];
        }
    }

    public function update($product_id, $data)
    {
        $errors = $this->validate(['product_id' => $product_id] + $data);
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        $this->db->beginTransaction();
        try {
            // Xóa các biến thể không còn tồn tại
            $delete_query = "DELETE FROM product_variants 
                            WHERE product_id = :product_id 
                            AND (size_id NOT IN (:size_ids) OR color_id NOT IN (:color_ids))";
            $this->db->runQuery($delete_query, [
                ':product_id' => $product_id,
                ':size_ids' => implode(',', $data['size_id']),
                ':color_ids' => implode(',', $data['color_id'])
            ]);

            // Thêm các biến thể mới
            foreach ($data['size_id'] as $size_id) {
                foreach ($data['color_id'] as $color_id) {
                    if (!$this->exists($product_id, $size_id, $color_id)) {
                        $query = "INSERT INTO product_variants (product_id, size_id, color_id) 
                                VALUES (:product_id, :size_id, :color_id)";
                        $this->db->runQuery($query, [
                            ':product_id' => $product_id,
                            ':size_id' => $size_id,
                            ':color_id' => $color_id
                        ]);
                    }
                }
            }

            $this->db->commit();
            return ['success' => true];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Update error: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Lỗi khi cập nhật biến thể sản phẩm']];
        }
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM product_variants WHERE id = :id";
            $this->db->runQuery($query, [':id' => $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Delete error: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Lỗi khi xóa biến thể sản phẩm']];
        }
    }
}

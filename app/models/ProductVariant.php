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
            if (!$id) return null; // Nếu không có ID, trả về null
            $db = new Database();
            $query = "SELECT * FROM product_variants WHERE id = :id LIMIT 1";
            return $db->runQuery($query, [':id' => $id])[0] ?? null;
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
            return $this->db->runQuery($query, [':product_id' => $product_id]);
        }
        public function searchVariants($filters = []) {
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
        
            // Run the query and return the result
            return $this->db->runQuery($query, $params);
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

            return $this->db->runQuery($query);
        }

        public function create($product_id, $size_id, $color_id)
        {
            $query = "INSERT INTO product_variants (product_id, size_id, color_id) 
                      VALUES (:product_id, :size_id, :color_id)";
            return $this->db->runQuery($query, [
                ':product_id' => $product_id,
                ':size_id' => $size_id,
                ':color_id' => $color_id
            ]);
        }

        public function update($product_id, $data)
        {
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

                // Kiểm tra biến thể hiện có
                $check_query = "SELECT size_id, color_id FROM product_variants WHERE product_id = :product_id";
                $existing_variants = $this->db->runQuery($check_query, [':product_id' => $product_id]);

                $insert_query = "INSERT INTO product_variants (product_id, size_id, color_id) 
                                 VALUES (:product_id, :size_id, :color_id)";

                foreach ($data['size_id'] as $size_id) {
                    foreach ($data['color_id'] as $color_id) {
                        // Kiểm tra xem biến thể đã tồn tại chưa
                        $exists = false;
                        foreach ($existing_variants as $variant) {
                            if ($variant['size_id'] == $size_id && $variant['color_id'] == $color_id) {
                                $exists = true;
                                break;
                            }
                        }

                        // Chỉ chèn nếu chưa tồn tại
                        if (!$exists) {
                            $this->db->runQuery($insert_query, [
                                ':product_id' => $product_id,
                                ':size_id' => $size_id,
                                ':color_id' => $color_id
                            ]);
                        }
                    }
                }

                $this->db->commit();
                return true;
            } catch (PDOException $e) {
                $this->db->rollBack();
                error_log("Update error: " . $e->getMessage());
                return false;
            }
        }

        public function delete($id)
        {
            $query = "DELETE FROM product_variants WHERE id = :id";
            return $this->db->runQuery($query, [':id' => $id]);
        }
    }

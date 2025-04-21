<?php
// app/models/Product.php
require_once __DIR__ . '/../config/database.php';
class Product
{
    private $db;

    public function __construct()
    {
        $this->db =  new database();
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM products ORDER BY id DESC";
        return $this->db->runQuery($query);
    }
    public static function all()
    {
        try {
            $db = new Database();
            $conn = $db->getConnection();

            $sql = "SELECT * FROM products ORDER BY created_at DESC, id DESC";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    public function getVariantsByProductId($product_id)
    {
        $query = "
            SELECT pv.id AS variant_id, pv.product_id, 
                   s.id AS size_id, s.name AS size_name, 
                   c.id AS color_id, c.color_code AS color_name
            FROM product_variants pv
            LEFT JOIN sizes s ON pv.size_id = s.id
            LEFT JOIN colors c ON pv.color_id = c.id
            WHERE pv.product_id = ?
        ";
        return $this->db->runQuery($query, [$product_id])->fetchAll(PDO::FETCH_ASSOC);
    }



    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->db->runQuery($sql, [$id]);

        // Nếu $stmt là một đối tượng PDOStatement, gọi fetch()
        if ($stmt instanceof PDOStatement) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return false; // Trả về false nếu không tìm thấy sản phẩm
    }
    public function getRelatedProducts($category_id, $exclude_id)
    {
        $sql = "SELECT * FROM products WHERE category_id = ? AND id != ? LIMIT 4";
        $stmt = $this->db->runQuery($sql, [$category_id, $exclude_id]);

        if ($stmt instanceof PDOStatement) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function getProductsByCategoryId($categoryId)
    {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        $stmt = $this->db->runQuery($sql, [$categoryId]);

        if ($stmt instanceof PDOStatement) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }

    public function createProduct($name, $price, $description, $image, $quantity, $category_id)
    {
        $sql = "INSERT INTO products (name, price, description, image, quantity, category_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->runQuery($sql, [$name, $price, $description, $image, $quantity, $category_id]);
    }

    public function updateProduct($id, $name, $price, $description, $image, $quantity, $category_id)
    {
        $sql = "UPDATE products SET name = ?, price = ?, description = ?, image = ?, quantity = ?, category_id = ? WHERE id = ?";
        return $this->db->runQuery($sql, [$name, $price, $description, $image, $quantity, $category_id, $id]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        return $this->db->runQuery($sql, [$id]);
    }
    public function searchProducts($keyword)
    {
        $query = "SELECT * FROM products WHERE name LIKE :keyword";
        return $this->db->runQuery($query, [':keyword' => "%$keyword%"]);
    }
    // lọc theo giá 
    public function getProductsByMinMax($min = null, $max = null)
    {
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        if (!empty($min)) {
            $sql .= " AND price >= :min";
            $params[':min'] = $min;
        }

        if (!empty($max)) {
            $sql .= " AND price <= :max";
            $params[':max'] = $max;
        }

        $stmt = $this->db->runQuery($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductsByVariants($colorId, $sizeId)
    {
        $sql = "SELECT DISTINCT p.* 
                FROM products p
                JOIN product_variants pv ON p.id = pv.product_id
                WHERE 1=1";

        $params = [];

        if ($colorId) {
            $sql .= " AND pv.color_id = :color_id";
            $params[':color_id'] = $colorId;
        }

        if ($sizeId) {
            $sql .= " AND pv.size_id = :size_id";
            $params[':size_id'] = $sizeId;
        }

        return $this->db->runQuery($sql, $params)->fetchAll();
    }
}

<?php
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductVariant.php';
ob_start(); // Bắt đầu bộ đệm đầu ra

class UserController
{
    private $conn;
    private $productModel;
    private $categoriesModel;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "clothing_store";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }

        $this->categoriesModel = new Categories($this->conn);
        $this->productModel = new Product($this->conn);
    }

    // Đóng kết nối khi kết thúc
    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    // Hiển thị trang chủ với danh sách sản phẩm
    public function home()
    {
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoriesModel->getAllCategories();
        include __DIR__ . "/../views/guest/trangchu.php";
    }
    public function showProductDetail($id) {
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoriesModel->getAllCategories();
        
        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }
    
        // Lấy danh sách biến thể theo ID sản phẩm
        $variants = $this->productModel->getVariantsByProductId($id);
    
        // Lấy danh sách màu sắc và kích thước theo sản phẩm
        $colors = [];
        $sizes = [];
    
        foreach ($variants as $variant) {
            $colors[$variant['color_id']] = $variant['color_name'];
            $sizes[$variant['size_id']] = $variant['size_name'];
        }
    
        // Lấy sản phẩm liên quan
        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id);
    
        // Load giao diện chi tiết sản phẩm
        include __DIR__ . "/../views/guest/chitietsanpham.php";
    }
    
    
    public function showCategory($categoryId)
    {
        $products = $this->productModel->getProductsByCategoryId($categoryId);
        $categories = $this->categoriesModel->getCategoriesById($categoryId);
        include __DIR__ . "/../views/guest/danhmuc.php";
    }
    public function updateUser($id, $name, $phone, $email, $address)
    {
        if (empty($name) || empty($email)) {
            die("Tên và Email không được để trống.");
        }

        $query = "UPDATE users SET name = ?, phone = ?, email = ?, address = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ssssi", $name, $phone, $email, $address, $id);

        if (!$stmt->execute()) {
            die("Lỗi khi cập nhật: " . $stmt->error);
        }
    }

    public function editCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            $email = trim($_POST['email']);
            $address = trim($_POST['address']);

            $this->updateUser($id, $name, $phone, $email, $address);

            header("Location: index.php?page=user");
            exit;
        } else {
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $userData = $this->getUserById($id);
                include 'app/views/admin/edit_customer.php';
            }
        }
    }

    public function getUserById($id)
    {
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function deleteCustomer()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "DELETE FROM users WHERE id = ?";
            $stmt = $this->conn->prepare($query);

            if (!$stmt) {
                die("Lỗi prepare: " . $this->conn->error);
            }

            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                header("Location: index.php?page=user");
                exit;
            } else {
                echo "Xóa người dùng thất bại!";
            }
        }
    }
    public function search() {
        $keyword = $_GET['q'] ?? ''; // Lấy từ khóa từ URL
        $products = $this->productModel->searchProducts($keyword); // Gọi model để tìm sản phẩm
        include __DIR__ . '/../views/guest/timkiem.php'; // Load trang hiển thị kết quả
    }
    

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /duan11/index.php"); // Chuyển hướng về trang chủ hoặc trang login
        exit();
    }
}
$userController = new UserController();

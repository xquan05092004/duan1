<?php
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductVariant.php';
require_once __DIR__ . '/../models/add_to_cart.php';
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
    public function showProductDetail($id)
    {
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
        $categoryId = intval($categoryId);
        $allCategories = $this->categoriesModel->getAllCategories();

        // Lấy tất cả sản phẩm thuộc danh mục
        $products = $this->productModel->getProductsByCategoryId($categoryId);
        
        // Lấy 1 danh mục
        $category = $this->categoriesModel->getCategoriesById($categoryId); // nên đặt lại tên thành getCategoryById
        
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
    public function search()
    {
        $keyword = $_GET['q'] ?? ''; // Lấy từ khóa từ URL
        $products = $this->productModel->searchProducts($keyword); // Gọi model để tìm sản phẩm
        include __DIR__ . '/../views/guest/timkiem.php'; // Load trang hiển thị kết quả
    }
    public function index()
    {
        // Lấy danh mục được chọn từ URL (nếu có)
        $category_id = isset($_GET['category']) ? $_GET['category'] : null;

        // Gọi dữ liệu từ model
        $products = $this->productModel->getAllProducts($category_id);
        $categories = $this->categoriesModel->getAllCategories();

        // Xử lý trường hợp không có sản phẩm
        if ($products === null || $products === false) {
            $products = [];
        }

        // Gọi view hiển thị sản phẩm người dùng
        include 'app/views/guest/sanpham.php';
    }
    public function addToCart($product_id, $quantity, $color, $size)
    {
        // Kiểm tra thông tin đầu vào
        if (empty($product_id) || empty($quantity) || empty($color) || empty($size)) {
            echo "Thiếu thông tin cần thiết!";
            return;
        }

        // Đảm bảo phiên đã được khởi động
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $query = "SELECT name, image, price FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            echo "Sản phẩm không tồn tại!";
            return;
        }

        $product_image = $product['image'] ?? '';
        $product_name = $product['name'] ?? '';
        $product_price = $product['price'] ?? 0;

        // Tạo mục giỏ hàng
        $item = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'quantity' => $quantity,
            'color' => $color,
            'size' => $size,
            'image' => $product_image,
            'price' => $product_price
        ];

        // Khởi tạo giỏ hàng nếu chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Thêm vào giỏ hàng trong phiên
        $_SESSION['cart'][] = $item;

        // Lưu vào cơ sở dữ liệu nếu người dùng đã đăng nhập
        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            $user_id = $_SESSION['user']['id'];

            $query = "INSERT INTO cart (user_id, product_id, quantity, color, size, image, added_at, status) 
                 VALUES (?, ?, ?, ?, ?, ?, NOW(), 'active')";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iiiiis", $user_id, $product_id, $quantity, $color, $size, $product_image);
            $stmt->execute();
        }

        // Chuyển hướng đến trang giỏ hàng
        header("Location: index.php?page=view_cart");
        exit;
    }

    public function viewCart()
    {
        // Lấy danh sách tất cả màu và size để hiển thị trong dropdown
        $available_colors = [];
        $available_sizes = [];

        $query = "SELECT id, color_code FROM colors";
        $result = $this->conn->query($query);
        if ($result) {
            $available_colors = $result->fetch_all(MYSQLI_ASSOC);
        }

        $query = "SELECT id, name FROM sizes";
        $result = $this->conn->query($query);
        if ($result) {
            $available_sizes = $result->fetch_all(MYSQLI_ASSOC);
        }



        // Đảm bảo phiên đã được khởi động
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $cart_items = [];

        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            $user_id = $_SESSION['user']['id'];

            // Lấy các mục giỏ hàng từ cơ sở dữ liệu cho người dùng đã đăng nhập
            $query = "SELECT c.*, p.name as product_name, p.image as product_image, p.price,
                  cl.color_code as color_name, s.name as size_name
                  FROM cart c
                  JOIN products p ON c.product_id = p.id
                  LEFT JOIN colors cl ON c.color = cl.id
                  LEFT JOIN sizes s ON c.size = s.id
                  WHERE c.user_id = ? AND c.status = 'active'";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $cart_items = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            // Sử dụng giỏ hàng trong phiên cho khách
            $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

            // Lấy thông tin bổ sung cho các mục giỏ hàng trong phiên nếu cần
            // Sử dụng giỏ hàng trong phiên cho khách
            $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

            if (!empty($cart_items)) {
                foreach ($cart_items as $key => $item) {
                    // Lấy tên màu
                    if (isset($item['color']) && is_numeric($item['color'])) {
                        $query = "SELECT color_code FROM colors WHERE id = ?";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bind_param("i", $item['color']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($color = $result->fetch_assoc()) {
                            $cart_items[$key]['color_name'] = $color['color_code'];
                        }
                    }

                    // Lấy tên kích thước
                    if (isset($item['size']) && is_numeric($item['size'])) {
                        $query = "SELECT name FROM sizes WHERE id = ?";
                        $stmt = $this->conn->prepare($query);
                        $stmt->bind_param("i", $item['size']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($size = $result->fetch_assoc()) {
                            $cart_items[$key]['size_name'] = $size['name'];
                        }
                    }
                }

                // ✅ Cập nhật lại session để phản ánh dữ liệu mới
                $_SESSION['cart'] = $cart_items;
            }
        }

        // Hiển thị trang giỏ hàng
        include __DIR__ . '/../views/guest/cart_view.php';
    }
    public function updateCartVariant()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $color = $_POST['color'];
        $size = $_POST['size'];
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $cart_id_or_index = $_POST['cart_id'];

        if (isset($_SESSION['user'])) {
            // Người dùng đã đăng nhập → cập nhật DB
            $query = "UPDATE cart SET color = ?, size = ?, quantity = ? WHERE cart_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iiii", $color, $size, $quantity, $cart_id_or_index);
            $stmt->execute();
        } else {
            // Người dùng chưa đăng nhập → cập nhật trong session
            if (isset($_SESSION['cart'][$cart_id_or_index])) {
                $_SESSION['cart'][$cart_id_or_index]['color'] = $color;
                $_SESSION['cart'][$cart_id_or_index]['size'] = $size;
                $_SESSION['cart'][$cart_id_or_index]['quantity'] = $quantity;
            }
        }


        header("Location: index.php?page=view_cart");
        exit;
    }

    public function deleteCartItem()
    {
        // Đảm bảo phiên đã được khởi động
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            // Đối với người dùng đã đăng nhập - xóa từ cơ sở dữ liệu
            if (isset($_GET['id'])) {
                $cart_id = $_GET['id'];
                $user_id = $_SESSION['user']['id'];

                $query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("ii", $cart_id, $user_id);
                $stmt->execute();
            }
        } else {
            // Đối với khách - xóa từ phiên
            if (isset($_GET['index']) && isset($_SESSION['cart'][$_GET['index']])) {
                unset($_SESSION['cart'][$_GET['index']]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Đặt lại các khóa mảng
            }
        }

        // Chuyển hướng về trang giỏ hàng
        header("Location: index.php?page=view_cart");
        exit;
    }
    public function update_cart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page']) && $_GET['page'] === 'update_cart') {
            $input = json_decode(file_get_contents("php://input"), true);

            if (isset($input['index'], $input['quantity'], $input['color'], $input['size'])) {
                $index = $input['index'];
                $_SESSION['cart'][$index]['quantity'] = (int)$input['quantity'];
                $_SESSION['cart'][$index]['color_id'] = $input['color'];
                $_SESSION['cart'][$index]['size_id'] = $input['size'];

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu']);
            }
            exit;
        }
    }
    public function createOrder()
    {
        $user_id = $_SESSION['user']['id'];

        $query = "INSERT INTO orders (user_id, status, payment_status) VALUES (?, 'chưa xác nhận', 'chưa thanh toán')";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $order_id = $this->conn->insert_id;

        $query = "SELECT * FROM cart WHERE user_id = ? AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cartItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($cartItems as $item) {
            $query = "INSERT INTO order_items (order_id, product_variant_id, quantity, price) 
                      VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }

        $query = "UPDATE cart SET status = 'ordered' WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        header('Location: /order/confirmation');
        exit;
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

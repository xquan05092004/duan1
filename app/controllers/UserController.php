<?php
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductVariant.php';
require_once __DIR__ . '/../models/add_to_cart.php';
ob_start(); // Bắt đầu bộ đệm đầu ra

class UserController
{
    private $db;
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

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    private function ensureConnection()
    {
        if ($this->conn->ping() === false) {
            $this->conn = new mysqli("localhost", "root", "", "clothing_store");
            if ($this->conn->connect_error) {
                die("Kết nối cơ sở dữ liệu thất bại: " . $this->conn->connect_error);
            }
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
    // 1. Lấy thông tin sản phẩm
    $product = $this->productModel->getProductById($id);
    if (!$product) {
        die("Sản phẩm không tồn tại!");
    }

    // 2. Lấy danh mục và biến thể
    $categories = $this->categoriesModel->getAllCategories();
    $variants = $this->productModel->getVariantsByProductId($id);

    // 3. Phân tách màu sắc và kích cỡ
    $colors = [];
    $sizes = [];
    foreach ($variants as $variant) {
        $colors[$variant['color_id']] = $variant['color_name'];
        $sizes[$variant['size_id']] = $variant['size_name'];
    }

    // 4. Sản phẩm liên quan (cùng category, loại trừ sản phẩm hiện tại)
    $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $product['id']);


    // 5. Lấy bình luận
    $commentModel = new Comment();
    $comments = $commentModel->getCommentsByProductId($id);

    // 6. Gửi dữ liệu qua view
    $product_id = $id;
    include __DIR__ . "/../views/guest/chitietsanpham.php";
}



    public function showCategory($categoryId)
    {
        $categoryId = intval($categoryId);
        $allCategories = $this->categoriesModel->getAllCategories();

        // Lấy tất cả sản phẩm thuộc danh mục
        $products = $this->productModel->getProductsByCategoryId($categoryId);

        // Lấy 1 danh mục
        $category = $this->categoriesModel->getCategoriesById($categoryId);

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
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!";
            header("Location: index.php?page=login");
            exit;
        }

        if (empty($product_id) || empty($quantity) || empty($color) || empty($size)) {
            $_SESSION['error'] = "Thiếu thông tin cần thiết để thêm vào giỏ hàng!";
            header("Location: index.php?page=view_cart");
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        $query = "SELECT name, image, price FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            $_SESSION['error'] = "Sản phẩm không tồn tại!";
            header("Location: index.php?page=view_cart");
            exit;
        }

        $product_image = $product['image'] ?? '';
        $product_name = $product['name'] ?? '';
        $product_price = $product['price'] ?? 0;

        $query = "SELECT cart_id, quantity FROM cart WHERE user_id = ? AND product_id = ? AND color = ? AND size = ? AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("iiii", $user_id, $product_id, $color, $size);
        $stmt->execute();
        $result = $stmt->get_result();
        $existing_item = $result->fetch_assoc();

        if ($existing_item) {
            $new_quantity = $existing_item['quantity'] + $quantity;
            $query = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                die("Lỗi prepare: " . $this->conn->error);
            }
            $stmt->bind_param("ii", $new_quantity, $existing_item['cart_id']);
            $stmt->execute();
        } else {
            $query = "INSERT INTO cart (user_id, product_id, quantity, color, size, image, added_at, status) 
                     VALUES (?, ?, ?, ?, ?, ?, NOW(), 'active')";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                die("Lỗi prepare: " . $this->conn->error);
            }
            $stmt->bind_param("iiiiis", $user_id, $product_id, $quantity, $color, $size, $product_image);
            $stmt->execute();
        }

        $_SESSION['message'] = "Sản phẩm đã được thêm vào giỏ hàng!";
        header("Location: index.php?page=view_cart");
        exit;
    }

    public function viewCart()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xem giỏ hàng!";
            header("Location: index.php?page=login");
            exit;
        }

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

        $user_id = $_SESSION['user']['id'];
        $query = "SELECT c.*, p.name as product_name, p.image as product_image, p.price,
                 cl.color_code as color_name, s.name as size_name
                 FROM cart c
                 JOIN products p ON c.product_id = p.id
                 LEFT JOIN colors cl ON c.color = cl.id
                 LEFT JOIN sizes s ON c.size = s.id
                 WHERE c.user_id = ? AND c.status = 'active'";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);

        include __DIR__ . '/../views/guest/cart_view.php';
    }

    public function updateCartVariant()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để cập nhật giỏ hàng!";
            header("Location: index.php?page=login");
            exit;
        }

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $color = $_POST['color'];
        $size = $_POST['size'];
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $cart_id = $_POST['cart_id'];

        $query = "UPDATE cart SET color = ?, size = ?, quantity = ? WHERE cart_id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("iiii", $color, $size, $quantity, $cart_id);
        $stmt->execute();

        $_SESSION['message'] = "Giỏ hàng đã được cập nhật!";
        header("Location: index.php?page=view_cart");
        exit;
    }

    public function deleteCartItem()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để xóa sản phẩm khỏi giỏ hàng!";
            header("Location: index.php?page=login");
            exit;
        }

        if (isset($_GET['id'])) {
            $cart_id = $_GET['id'];
            $user_id = $_SESSION['user']['id'];

            $query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                die("Lỗi prepare: " . $this->conn->error);
            }
            $stmt->bind_param("ii", $cart_id, $user_id);
            $stmt->execute();

            $_SESSION['message'] = "Sản phẩm đã được xóa khỏi giỏ hàng!";
        }

        header("Location: index.php?page=view_cart");
        exit;
    }

    public function checkout()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }
        include __DIR__ . '/../views/guest/checkout.php';
    }

    public function processCheckout()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để thanh toán!";
            header("Location: index.php?page=login");
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        $query = "SELECT c.*, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ? AND c.status = 'active'";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi prepare (lấy dữ liệu giỏ hàng): " . $this->conn->error);
            die("Lỗi prepare (lấy dữ liệu giỏ hàng): " . $this->conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        if (empty($cart_items)) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header("Location: index.php?page=view_cart");
            exit;
        }

        error_log("Cart items: " . json_encode($cart_items));

        $total_amount = 0;
        foreach ($cart_items as $item) {
            if (!isset($item['price']) || !isset($item['quantity'])) {
                error_log("Lỗi: Dữ liệu giỏ hàng không hợp lệ: " . json_encode($item));
                $_SESSION['error'] = "Dữ liệu giỏ hàng không hợp lệ!";
                header("Location: index.php?page=checkout");
                exit;
            }
            $total_amount += $item['price'] * $item['quantity'];
        }

        $street_address = $_POST['street_address'] ?? '';
        $ward = $_POST['ward'] ?? '';
        $district = $_POST['district'] ?? '';
        $city = $_POST['city'] ?? '';
        $address = "$street_address, $ward, $district, $city";
        $payment_method = $_POST['payment_method'] ?? 1;

        $query = "INSERT INTO orders (user_id, address, payment_method, status, payment_status, total_amount, created_at) 
          VALUES (?, ?, ?, 'chưa xác nhận', 'chưa thanh toán', ?, NOW())";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi prepare (thêm đơn hàng): " . $this->conn->error);
            $_SESSION['error'] = "Lỗi hệ thống khi tạo đơn hàng: " . $this->conn->error;
            header("Location: index.php?page=checkout");
            exit;
        }
        $stmt->bind_param("isid", $user_id, $address, $payment_method, $total_amount);
        if (!$stmt->execute()) {
            error_log("Lỗi execute (thêm đơn hàng): " . $stmt->error);
            $_SESSION['error'] = "Lỗi hệ thống khi tạo đơn hàng: " . $stmt->error;
            header("Location: index.php?page=checkout");
            exit;
        }
        $order_id = $stmt->insert_id;
        $stmt->close();

        foreach ($cart_items as $item) {
            $query = "SELECT pv.id FROM product_variants pv 
                 WHERE pv.product_id = ? AND pv.color_id = ? AND pv.size_id = ? LIMIT 1";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                error_log("Lỗi prepare (tìm variant): " . $this->conn->error);
                die("Lỗi prepare (tìm variant): " . $this->conn->error);
            }
            $stmt->bind_param("iii", $item['product_id'], $item['color'], $item['size']);
            $stmt->execute();
            $result = $stmt->get_result();
            $variant = $result->fetch_assoc();
            $stmt->close();

            if (!$variant || !isset($variant['id'])) {
                error_log("Không tìm thấy variant cho sản phẩm: " . $item['product_id'] .
                    ", màu: " . $item['color'] . ", size: " . $item['size']);
                continue;
            }

            $product_variant_id = $variant['id'];
            $query = "INSERT INTO order_items (order_id, product_variant_id, quantity, price) 
                VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                error_log("Lỗi prepare (thêm chi tiết đơn hàng): " . $this->conn->error);
                die("Lỗi prepare (thêm chi tiết đơn hàng): " . $this->conn->error);
            }
            $stmt->bind_param("iiid", $order_id, $product_variant_id, $item['quantity'], $item['price']);
            if (!$stmt->execute()) {
                error_log("Lỗi execute (thêm chi tiết đơn hàng): " . $stmt->error);
                die("Lỗi execute (thêm chi tiết đơn hàng): " . $stmt->error);
            }
            $stmt->close();
        }
        $query = "DELETE FROM cart WHERE user_id = ? AND status = 'active'";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Lỗi prepare (xóa giỏ hàng): " . $this->conn->error);
            die("Lỗi prepare (xóa giỏ hàng): " . $this->conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();

        unset($_SESSION['cart']);
        $_SESSION['message'] = "Đơn hàng đã được đặt thành công!";
        $_SESSION['last_order_id'] = $order_id;
        header("Location: index.php?page=order_success");
        exit;
    }

    public function manageOrders()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        $user_id = $_SESSION['user']['id'];

        $query = "SELECT o.id, o.created_at, o.total_amount, o.status, o.payment_status, o.payment_method, pm.name as payment_method_name 
      FROM orders o 
      LEFT JOIN payment_methods pm ON o.payment_method = pm.id 
      WHERE o.user_id = ? 
      ORDER BY o.created_at DESC";
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi prepare (truy vấn đơn hàng): " . $this->conn->error);
            die("Lỗi prepare (truy vấn đơn hàng): " . $this->conn->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();


        if (empty($orders)) {
            include __DIR__ . '/../views/guest/manage_orders.php';
            return;
        }

        $order_ids = array_column($orders, 'id');

        if (empty($order_ids)) {
            error_log("Không có order_ids để truy vấn chi tiết đơn hàng.");
            foreach ($orders as &$order) {
                $order['items'] = [];
            }
            include __DIR__ . '/../views/guest/manage_orders.php';
            return;
        }

        $placeholders = implode(',', array_fill(0, count($order_ids), '?'));

        // Ghi log để kiểm tra
        error_log("Order IDs: " . json_encode($order_ids));
        error_log("Placeholders: " . $placeholders);

        $query = "SELECT oi.order_id, oi.quantity, oi.price, p.name as product_name,
              s.name as size_name, c.color_code as color
              FROM order_items oi 
              JOIN product_variants pv ON oi.product_variant_id = pv.id
              JOIN products p ON pv.product_id = p.id 
              LEFT JOIN sizes s ON pv.size_id = s.id
              LEFT JOIN colors c ON pv.color_id = c.id
              WHERE oi.order_id IN ($placeholders)";

        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            error_log("Lỗi prepare (truy vấn chi tiết đơn hàng): " . $this->conn->error);
            die("Lỗi prepare (truy vấn chi tiết đơn hàng): " . $this->conn->error);
        }

        $types = str_repeat('i', count($order_ids));
        $stmt->bind_param($types, ...$order_ids);
        $stmt->execute();
        $result = $stmt->get_result();
        $order_items = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        foreach ($orders as &$order) {
            $order['items'] = [];
        }

        foreach ($order_items as $item) {
            foreach ($orders as &$order) {
                if ($item['order_id'] == $order['id']) {
                    $order['items'][] = $item;
                    break;
                }
            }
        }

        include __DIR__ . '/../views/guest/manage_orders.php';
    }
    public function cancelOrder()
    {
        $this->ensureConnection();
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if (!isset($_GET['id'])) {
            echo "Không tìm thấy đơn hàng!";
            return;
        }

        $order_id = (int)$_GET['id'];
        $user_id = $_SESSION['user']['id'];

        $query = "SELECT * FROM orders WHERE id = ? AND user_id = ? AND status = 'chưa xác nhận'";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("ii", $order_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();

        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại hoặc không thể hủy!";
            header("Location: index.php?page=manage_orders");
            exit;
        }

        $query = "UPDATE orders SET status = 'hủy' WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("i", $order_id);
        $stmt->execute();

        $_SESSION['message'] = "Đơn hàng đã được hủy thành công!";
        header("Location: index.php?page=manage_orders");
        exit;
    }


    // lọc sản phẩm theo giá
    public function filterByPrice()
    {
        $allCategories = $this->categoriesModel->getAllCategories();
        $categories = $this->categoriesModel->getAllCategories();
        $minPrice = $_GET['price_from'] ?? null;
        $maxPrice = $_GET['price_to'] ?? null;

        $productModel = new Product();
        $products = $productModel->getProductsByMinMax($minPrice, $maxPrice);

        include __DIR__ . '/../views/guest/locgia.php';
    }
    public function filterByVariant()
    {
        $allCategories = $this->categoriesModel->getAllCategories();
        $colorId = $_GET['color_id'] ?? null;
        $sizeId = $_GET['size_id'] ?? null;

        $categories = $this->categoriesModel->getAllCategories();
        $productModel = new Product();
        $products = $productModel->getProductsByVariants($colorId, $sizeId);

        include __DIR__ . '/../views/guest/locgia.php';
    }
    public function guiBinhLuan()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user']['id'];
            $product_id = $_POST['product_id'] ?? null;
            $content = $_POST['content'] ?? '';

            if ($product_id && $content) {
                require_once 'app/models/Comment.php';
                $commentModel = new Comment();
                $commentModel->create($user_id, $product_id, $content);
                header("Location: index.php?page=chitiet&id=$product_id");
                exit;
            } else {
                echo "Thiếu thông tin!";
            }
        }
    }

    public function show($productId)
    {
        $productModel = new Product();
        
        // Lấy chi tiết sản phẩm hiện tại
        $product = $productModel->getProductById($productId);
        
        // Lấy sản phẩm liên quan cùng category_id
        $relatedProducts = $productModel->getRelatedProducts($product['category_id'], $product['id']);

        // Truyền dữ liệu sang view
        include 'views/product_detail.php';
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

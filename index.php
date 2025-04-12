<?php
session_start();
// Kết nối cơ sở dữ liệu
require_once 'app/config/database.php';

// Tải các Controller cần thiết
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/UserController.php';


// Lấy tham số từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : null;
// Điều hướng URL
if (!isset($_SESSION['user'])) {
    $userController->home(); // ✅ Gọi đúng controller để truyền biến
    exit;
}

$user = $_SESSION['user'];
$role = $user['role'] ?? 'user';

if ($role === 'admin') {
    $page = $_GET['page'] ?? 'dashboard';

    switch ($page) {
        case 'home':
            $userController->home();
            break;
        case 'chitiet':
            $userController->showProductDetail($_GET['id']);
            break;
        case 'search':
            $userController->search();
            break;
        case 'showCategory':
            $userController->showCategory($_GET['id']);
            break;
        case 'product':
            $adminController->listProducts();
            break;
        case 'sanpham':
            $userController->index();
            break;
        case 'products':
            if (isset($_GET['id'])) {
                $adminController->viewProduct($_GET['id']);
            } else {
                echo "Sản phẩm không tồn tại!";
            }
            break;
        case 'create_product':
            $adminController->createProduct();
            break;
        case 'edit_product':
            if (isset($_GET['id'])) {
                $adminController->updateProduct($_GET['id']);
            } else {
                echo "Sản phẩm không tồn tại!";
            }
            break;
        case 'delete_product':
            if (isset($_GET['id'])) {
                $adminController->deleteProduct($_GET['id']);
            } else {
                echo "Sản phẩm không tồn tại!";
            }
            break;
        case 'categories':
            $adminController->listCategories();
            break;
        case 'add_categories':
            $adminController->addCategories();
            break;
        case 'edit_categories':
            $adminController->editCategories();
            break;
        case 'delete_categories':
            $adminController->deleteCategories();
            break;
        case 'product_variants':
            include 'app/views/admin/product_variant/product_variants.php';
            break;
        case 'add_variant':
            include 'app/views/admin/product_variant/add_variant.php';
            break;
        case 'edit_variant':
            include 'app/views/admin/product_variant/edit_variant.php';
            break;
        case 'user':
            include 'app/views/admin/user.php'; // tài khoản
            break;
        case 'edit_customer':
            $userController->editCustomer();  // Gọi phương thức editCustomer() trong UserController
            break;
        case 'delete_customer':
            $userController->deleteCustomer(); // Gọi phương thức xóa trong controller
            break;
        case 'donhang':
            $adminController->listOrder();
            break;
        case 'capnhatorder':
            $adminController->updateStatus();
            break;
        case 'binhluan':
            $adminController->listComments();
            break;
        case 'ttbinhluan':
            $adminController->updateCommentStatus();
            break;
        case 'xoabinhluan':
            $adminController->deleteComment();
            break;
        case 'add_to_cart':
            if (isset($_GET['product_id'], $_GET['quantity'], $_GET['color'], $_GET['size'])) {
                $product_id = $_GET['product_id'];
                $quantity = $_GET['quantity'];
                $color = $_GET['color'];
                $size = $_GET['size'];
                $userController->addToCart($product_id, $quantity, $color, $size);
            } else {
                echo "Vui lòng chọn đủ thông tin sản phẩm!";
            }
            break;
        case 'checkout':
            $userController->checkout();
            break;
        case 'process_checkout':
            $userController->processCheckout();
            break;
        case 'loc':
            if ($action == 'filter') {
                $userController->filterByPrice();
            } else {
                $userController->index(); // hoặc show all
            }
            break;
        case 'order_success':
            include 'app/views/guest/order_success.php';
            break;
        case 'manage_orders':
            $userController->manageOrders();
            break;
        case 'cancel_order':
            $userController->cancelOrder();
            break;
        case 'view_cart':
            $userController->viewCart();
            break;
        case 'update_cart_variant':
            $userController->updateCartVariant();
            break;
        case 'delete_cart':
            $userController->deleteCartItem();
            break;
        case 'filter_variant':
            $userController->filterByVariant();
            break;

        default:
            include 'app/views/guest/list.php'; // Trang chủ
            break;
    }
} else {
    // USER đã đăng nhập
    $page = $_GET['page'] ?? 'home';

    switch ($page) {
        case 'home':
            $userController->home();
            break;
        case 'search':
            $userController->search();
            break;
        case 'loc':
            if ($action == 'filter') {
                $userController->filterByPrice();
            } else {
                $userController->index(); // hoặc show all
            }
            break;
        case 'chitiet':
            isset($_GET['id']) ? $userController->showProductDetail($_GET['id']) : print("Không có sản phẩm!");
            break;
        case 'add_to_cart':
            if (isset($_GET['product_id'], $_GET['quantity'], $_GET['color'], $_GET['size'])) {
                $product_id = $_GET['product_id'];
                $quantity = $_GET['quantity'];
                $color = $_GET['color'];
                $size = $_GET['size'];
                $userController->addToCart($product_id, $quantity, $color, $size);
            } else {
                echo "Vui lòng chọn đủ thông tin sản phẩm!";
            }
            break;
        case 'sanpham':
            $userController->index();
            break;
        case 'view_cart':
            $userController->viewCart();
            break;
        case 'update_cart_variant':
            $userController->updateCartVariant();
            break;
        case 'delete_cart':
            $userController->deleteCartItem();
            break;
        case 'checkout':
            $userController->checkout();
            break;
        case 'process_checkout':
            $userController->processCheckout();
            break;
        case 'order_success':
            include 'app/views/guest/order_success.php';
            break;
        case 'manage_orders':
            $userController->manageOrders();
            break;
        case 'cancel_order':
            $userController->cancelOrder();
            break;
        case 'showCategory':
            isset($_GET['id']) ? $userController->showCategory($_GET['id']) : print("Không có danh mục!");
            break;
        default:
            $userController->home();
            break;
    }
}

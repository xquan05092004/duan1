<?php
session_start();
// Kết nối cơ sở dữ liệu
require_once 'app/config/database.php';

// Tải các Controller cần thiết
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/UserController.php';

// Lấy tham số từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
// Điều hướng URL
switch ($page) {
    case 'home':
        $userController->home();
        break;
    case 'chitiet':
        $userController->showProductDetail($_GET['id']);
        break;
    case 'showCategory':
        $userController->showCategory($_GET['id']);
        break;
    case 'product':
        $adminController->listProducts();
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
    case 'user':
        include 'app/views/admin/user.php'; // tài khoản
        break;

    case 'donhang':
        include 'app/views/admin/donhang.php'; // đơn hàng
        break;
    case 'binhluan':
        include 'app/views/admin/binhluan.php'; // bình luận
        break;
    default:
        include 'app/views/guest/list.php'; // Trang chủ
        break;
}

<?php
session_start();
// Kết nối cơ sở dữ liệu
require_once 'app/config/database.php';

// Tải các Controller cần thiết
require_once 'app/controllers/AdminController.php';

// Lấy tham số từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
// Điều hướng URL
switch ($page) {
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

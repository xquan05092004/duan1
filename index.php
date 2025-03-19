<?php
// Kết nối cơ sở dữ liệu
require_once 'app/config/database.php';

// Tải các Controller cần thiết
require_once 'app/controllers/ProductController.php';

// Lấy tham số từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Khởi tạo Controller với kết nối database
$productController = new ProductController($db);

// Điều hướng URL
switch ($page) {
    case 'products':
        $productController->listProducts();
        break;

    case 'product':
        if (isset($_GET['id'])) {
            $productController->viewProducts($_GET['id']);
        } else {
            echo "Sản phẩm không tồn tại!";
        }
        include 'app/views/admin/product.php'; // sản phẩm
        break;
    case 'brand':
        include 'app/views/admin/brand.php'; // danh mục
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

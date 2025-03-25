<?php
require_once __DIR__ . '/../models/Product.php';
ob_start(); // Bắt đầu bộ đệm đầu ra

class UserController {
    private $productModel;

    public function __construct() {
        $this->productModel = new Product();
    }

    // Hiển thị trang chủ với danh sách sản phẩm
    public function home() {
        $products = $this->productModel->getAllProducts();
        include __DIR__ . "/../views/guest/trangchu.php";
    }
    public function showProductDetail($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }

        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id);
        include __DIR__ . "/../views/guest/chitietsanpham.php";
    }
}
$userController = new UserController();
?>
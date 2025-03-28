<?php
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/Product.php';
ob_start(); // Bắt đầu bộ đệm đầu ra

class UserController
{
    private $productModel;
    private $categoriesModel;

    public function __construct()
    {
        $this->categoriesModel = new Categories();
        $this->productModel = new Product();
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
        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }

        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $id);
        include __DIR__ . "/../views/guest/chitietsanpham.php";
    }
    public function showCategory($categoryId)
    {
        $products = $this->productModel->getProductsByCategoryId($categoryId);
        $categories = $this->categoriesModel->getCategoriesById($categoryId);
        include __DIR__ . "/../views/guest/danhmuc.php";
    }
}
$userController = new UserController();

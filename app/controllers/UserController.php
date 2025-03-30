<?php
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/ProductVariant.php';
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

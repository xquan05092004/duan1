<?php
require_once 'app/models/Product.php';
require_once 'app/models/User.php';

class ProductController {
    private $productModel;

    public function __construct($db){
        $this -> productModel = new Product($db);
    }
    public function listProducts(){
        $products = $this->productModel->getAllProducts();
        include 'views/products/list.php';
    }  
    public function viewProducts($id){
        $products = $this->productModel->getProductById($id);
        include 'views/products/detail.php';
    }
}
?>
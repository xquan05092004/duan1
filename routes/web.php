<?php
require 'controllers/ProductController';
require 'config/Database.php';

$db = new PDO("mysql:host=localhost; dbname = clothing_store","root","");
$productController = new ProductController($db);

if($_GET['route'] == 'products'){
    $productController ->listProducts();
}else if($_GET['route'] == 'product' && isset($_GET['id'])) {
    $productController->viewProducts($_GET['id']);
}
?>
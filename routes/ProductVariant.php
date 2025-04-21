<?php
session_start();
require_once __DIR__ . '/../app/controllers/ProductVariantController.php';

$action = $_GET['action'] ?? 'index';
$controller = new ProductVariantController();

switch ($action) {
    case 'store':
        $controller->store();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $id = $_GET['id'] ?? null;
        $controller->delete($id);
        break;
    case 'search':
        $controller->search();
        break;
    default:
        header('Location: /duan11/index.php?page=product_variants');
        exit;
}

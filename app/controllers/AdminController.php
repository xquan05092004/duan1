<?php
require_once __DIR__ . '/../models/Categories.php';

class AdminController{
    private $categoriesModel;

    public function __construct(){
        $this->categoriesModel = new Categories();
    }
    public function listCategories() {
        $categories = $this->categoriesModel->getAllCategories();
        include "app/views/admin/categories.php";
    }
    
    public function addCategories(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $name = $_POST['name'];
            if($this->categoriesModel->addCategories($name)){
                header("Location: index.php?page=categories");
            }else{
                echo "Không thể thêm categories";
            }
        }
    }
    public function editCategories() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Nhận dữ liệu từ form
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? null;
            // Gọi model để cập nhật danh mục
            if ($this->categoriesModel->updateCategories($id, $name)) {
                header("Location: index.php?page=categories"); // Chuyển hướng về danh sách
                exit();
            } else {
                echo "❌ Cập nhật thất bại!";
            }
        } elseif (isset($_GET['id'])) {
            // Lấy dữ liệu danh mục để hiển thị trong form
            $id = $_GET['id'];
            $category = $this->categoriesModel->getCategoriesById($id);
    
            if ($category) {
                include __DIR__ . "/../views/admin/edit_category.php";
            } else {
                echo "❌ Không tìm thấy danh mục!";
            }
        } else {
            echo "❌ Không có ID danh mục!";
        }
    }
    
    
    
    public function deleteCategories() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
    
            $categoriesModel = new Categories(); // Đảm bảo khởi tạo model
    
            if ($categoriesModel->deleteCategories($id)) { 
                header("Location: index.php?page=categories");
                exit();
            } else {
                echo "❌ Lỗi khi xóa danh mục!";
            }
        } else {
            echo "❌ Không tìm thấy ID danh mục!";
        }
    }
    
}
$adminController = new AdminController();

?>
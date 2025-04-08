
<?php
require_once __DIR__ . '/../models/Categories.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/comment.php';

ob_start(); // Bắt đầu bộ đệm đầu ra

class AdminController
{
    private $categoriesModel;
    private $productModel;
    private $orderModel;


    public function __construct()
    {
        $this->categoriesModel = new Categories();
        $this->productModel = new Product();
        $this->orderModel = new Order();
    }
    public function listCategories()
    {
        $categories = $this->categoriesModel->getAllCategories();
        include "app/views/admin/categories.php";
    }

    public function addCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            if ($this->categoriesModel->addCategories($name)) {
                header("Location: index.php?page=categories");
            } else {
                echo "Không thể thêm categories";
            }
        }
    }
    public function editCategories()
    {
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



    public function deleteCategories()
    {
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
    public function listProducts()
    {
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoriesModel->getAllCategories();

        // Đảm bảo $products không null khi truyền vào view
        if ($products === null || $products === false) {
            $products = [];
        }

        // Truyền sản phẩm vào view
        include 'app/views/admin/product/list.php';
    }

    // Xem chi tiết sản phẩm
    public function viewProduct($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            die("Sản phẩm không tồn tại trong database!");
        }
        // Hiển thị sản phẩm
    }

    // Thêm sản phẩm mới
    public function createProduct()
    {
        // Lấy danh sách danh mục để hiển thị trong form
        $categoryModel = new Categories();
        $categories = $categoryModel->getAllCategories();

        // Xử lý nếu form được submit (phương thức POST)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $quantity = $_POST['quantity'];
            $category_id = $_POST['category_id'];

            // Xử lý upload file ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = 'public/uploads/'; // Đường dẫn lưu file

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                // Tạo tên file duy nhất
                $image = time() . '_' . $_FILES['image']['name'];
                $target_file = $upload_dir . $image;

                // Upload file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = ''; // Nếu upload thất bại, không lưu ảnh
                    $message = "Có lỗi xảy ra khi tải lên hình ảnh.";
                }
            }

            // Thêm sản phẩm vào cơ sở dữ liệu
            if ($this->productModel->createProduct($name, $price, $description, $image, $quantity, $category_id)) {
                $message = "Sản phẩm đã được thêm thành công!";
                header("Location: index.php?page=product");
                exit;
            } else {
                $message = "Lỗi khi thêm sản phẩm!";
            }
        }

        // Truyền danh mục vào view để hiển thị trong form
        include 'app/views/admin/product/create.php';
    }


    // Cập nhật sản phẩm
    public function updateProduct($id)
    {
        // Lấy danh sách danh mục để hiển thị trong form
        $categoryModel = new Categories();
        $categories = $categoryModel->getAllCategories();

        // Lấy thông tin sản phẩm cần cập nhật
        $product = $this->productModel->getProductById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'];
            $price = $_POST['price'];
            $description = $_POST['description'];
            $quantity = $_POST['quantity'];
            $category_id = $_POST['category_id'];

            // Giữ nguyên ảnh cũ nếu không có file mới
            $image = $product['image'];

            // Xử lý upload file mới
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = 'public/uploads/';

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }

                // Xóa file cũ nếu tồn tại
                if (!empty($product['image']) && file_exists($upload_dir . $product['image'])) {
                    unlink($upload_dir . $product['image']);
                }

                // Tạo tên file duy nhất
                $image = time() . '_' . $_FILES['image']['name'];
                $target_file = $upload_dir . $image;

                // Upload file
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image = $product['image']; // Giữ nguyên ảnh cũ nếu upload thất bại
                    $message = "Có lỗi xảy ra khi tải lên hình ảnh.";
                }
            }

            // Cập nhật sản phẩm
            if ($this->productModel->updateProduct($id, $name, $price, $description, $image, $quantity, $category_id)) {
                $message = "Sản phẩm đã được cập nhật thành công!";
                header("Location: index.php?page=product");
                exit;
            } else {
                $message = "Lỗi khi cập nhật sản phẩm!";
            }
        }

        // Truyền danh mục và sản phẩm vào view
        include 'app/views/admin/product/edit.php';
    }


    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        // Lấy thông tin sản phẩm trước khi xóa
        $product = $this->productModel->getProductById($id);

        if ($this->productModel->deleteProduct($id)) {
            // Xóa file ảnh nếu tồn tại
            if (!empty($product['image'])) {
                $upload_dir = 'public/uploads/';
                $file_path = $upload_dir . $product['image'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }

            $message = "Sản phẩm đã được xóa thành công!";
        } else {
            $message = "Lỗi khi xóa sản phẩm!";
        }

        header("Location: index.php?page=product");
        exit;
    }
    public function listOrder()
    {
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $orders = $this->orderModel->getOrders($status);
        include 'app/views/admin/donhang.php';
    }
    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'], $_POST['status'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];

            if ($this->orderModel->updateStatusOrder($id, $status)) {
                header("Location: index.php?page=donhang");
                exit();
            }
        } else {
            echo "Lỗi cập nhật trạng thái";
        }
    }
    public function listComments()
    {
        $commentModel = new Comment();
        $status = $_GET['status'] ?? null;
        $comments = $commentModel->getAllComments($status);

        include 'app/views/admin/binhluan.php'; // Phải nằm sau khi gán $comments
    }

    public function updateCommentStatus()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];
        $commentModel = new comment();
        $commentModel->updateComment($id, $status);
        header("Location: index.php?page=binhluan");
    }
    public function deleteComment()
    {
        $id = $_GET['id'];
        $commentModel = new comment();
        $commentModel->delete($id);
        header("Location: index.php?page=binhluan");
    }
}
ob_end_flush(); // Xuất nội dung ra trình duyệt

$adminController = new AdminController();

?>
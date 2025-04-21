<?php

require_once __DIR__ . '/../models/ProductVariant.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Size.php';
require_once __DIR__ . '/../models/Color.php';

class ProductVariantController
{
    private $db;
    private $productVariant;

    public function __construct()
    {
        $this->db = new Database();
        $this->productVariant = new ProductVariant($this->db);
    }

    public function index()
    {
        // Hiển thị danh sách biến thể
        require_once __DIR__ . '/../views/admin/product_variant/product_variants.php';
    }

    public function create()
    {
        // Hiển thị form thêm biến thể
        require_once __DIR__ . '/../views/admin/product_variant/add_variant.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Phương thức không được phép';
            header('Location: /duan11/index.php?page=product_variants');
            exit;
        }

        $data = [
            'product_id' => $_POST['product_id'] ?? null,
            'size_id' => $_POST['size_id'] ?? [],
            'color_id' => $_POST['color_id'] ?? []
        ];

        $result = $this->productVariant->create($data);

        if ($result['success']) {
            $_SESSION['success'] = 'Thêm biến thể thành công';
            header('Location: /duan11/index.php?page=product_variants');
        } else {
            $_SESSION['error'] = implode(', ', $result['errors']);
            header('Location: /duan11/index.php?page=add_variant');
        }
        exit;
    }

    public function edit($id)
    {
        $variant = $this->productVariant->find($id);
        if (!$variant) {
            $_SESSION['error'] = 'Không tìm thấy biến thể';
            header('Location: /duan11/index.php?page=product_variants');
            exit;
        }

        require_once __DIR__ . '/../views/admin/product_variant/edit_variant.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error'] = 'Phương thức không được phép';
            header('Location: /duan11/index.php?page=product_variants');
            exit;
        }

        $id = $_POST['id'] ?? null;
        $variant = $this->productVariant->find($id);
        if (!$variant) {
            $_SESSION['error'] = 'Không tìm thấy biến thể';
            header('Location: /duan11/index.php?page=product_variants');
            exit;
        }

        $data = [
            'size_id' => $_POST['size_id'] ?? [],
            'color_id' => $_POST['color_id'] ?? []
        ];

        $result = $this->productVariant->update($variant['product_id'], $data);

        if ($result['success']) {
            $_SESSION['success'] = 'Cập nhật biến thể thành công';
            header('Location: /duan11/index.php?page=product_variants');
        } else {
            $_SESSION['error'] = implode(', ', $result['errors']);
            header('Location: /duan11/index.php?page=edit_variant&id=' . $id);
        }
        exit;
    }

    public function delete($id)
    {
        $variant = $this->productVariant->find($id);
        if (!$variant) {
            $_SESSION['error'] = 'Không tìm thấy biến thể';
            header('Location: /duan11/index.php?page=product_variants');
            exit;
        }

        $result = $this->productVariant->delete($id);

        if ($result['success']) {
            $_SESSION['success'] = 'Xóa biến thể thành công';
        } else {
            $_SESSION['error'] = implode(', ', $result['errors']);
        }

        header('Location: /duan11/index.php?page=product_variants');
        exit;
    }

    public function search()
    {
        $filters = [
            'product_id' => $_GET['product_id'] ?? null,
            'size_id' => $_GET['size_id'] ?? null,
            'color_id' => $_GET['color_id'] ?? null
        ];

        $variants = $this->productVariant->searchVariants($filters);
        echo json_encode(['success' => true, 'data' => $variants]);
        exit;
    }
}

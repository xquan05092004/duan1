<h2>Thêm Biến Thể Sản Phẩm</h2>

<!-- Thêm vào trong thẻ <head> -->
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />

<!-- Thêm jQuery và Choices.js vào cuối file body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<?php
if (isset($_SESSION['error'])) {
    echo "<div style='color: red;'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>

<form action="/duan11/routes/ProductVariant.php?action=store" method="POST">

    <label>Sản phẩm:</label>
    <select name="product_id" id="product-select" required>
        <option value="">Chọn sản phẩm</option>
        <?php
        require_once(__DIR__ . '/../../../models/Product.php');
        $products = Product::all();
        foreach ($products as $product) {
            echo "<option value='" . $product['id'] . "'>" . $product['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label>Size:</label>
    <select name="size_id[]" id="size-select" multiple required>
        <?php
        require_once(__DIR__ . '/../../../models/Size.php');
        $sizes = Size::all();
        foreach ($sizes as $size) {
            echo "<option value='" . $size['id'] . "'>" . $size['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label>Color:</label>
    <select name="color_id[]" id="color-select" multiple required>
        <?php
        require_once(__DIR__ . '/../../../models/Color.php');
        $colors = Color::all();
        foreach ($colors as $color) {
            echo "<option value='" . $color['id'] . "'>" . $color['color_code'] . "</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Thêm</button>
</form>

<a href="/duan11/index.php?page=product_variants">← Quay lại danh sách</a>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Khởi tạo Choices cho các dropdown
        var sizeSelect = document.getElementById('size-select');
        var colorSelect = document.getElementById('color-select');
        // Thêm vào trong đoạn script đã có
        var productSelect = document.getElementById('product-select');
        new Choices(productSelect, {
            removeItemButton: false,
            searchEnabled: true,
            itemSelectText: 'Chọn sản phẩm',
            placeholder: true,
            placeholderValue: 'Chọn sản phẩm',
        });

        // Khởi tạo Choices.js cho các trường chọn nhiều
        new Choices(sizeSelect, {
            removeItemButton: true, // Hiển thị nút xóa các mục đã chọn
            searchEnabled: true, // Cho phép tìm kiếm
            itemSelectText: 'Chọn kích thước', // Văn bản mô tả
            placeholder: true, // Cho phép giữ placeholder
            placeholderValue: 'Chọn size',
        });

        new Choices(colorSelect, {
            removeItemButton: true, // Hiển thị nút xóa các mục đã chọn
            searchEnabled: true, // Cho phép tìm kiếm
            itemSelectText: 'Chọn màu', // Văn bản mô tả
            placeholder: true, // Cho phép giữ placeholder
            placeholderValue: 'Chọn màu',
        });
    });
</script>
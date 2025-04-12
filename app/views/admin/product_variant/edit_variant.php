<?php
require_once(__DIR__ . '/../../../models/ProductVariant.php');
require_once(__DIR__ . '/../../../models/Size.php');
require_once(__DIR__ . '/../../../models/Color.php');
// Lấy thông tin biến thể theo ID
$id = $_GET['id'] ?? null;
$variant = ProductVariant::find($id); // This should return the variant data
$sizes = Size::all();
$colors = Color::all();
?>

<h2>Sửa Biến Thể Sản Phẩm</h2>

<!-- Thêm vào trong thẻ <head> -->
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />

<!-- Thêm jQuery và Choices.js vào cuối file body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

<h2>Sửa Biến Thể Sản Phẩm</h2>

<?php
if (isset($_SESSION['error'])) {
    echo "<div style='color: red;'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}

// Lấy thông tin biến thể hiện tại

// Trong file edit_variant.php
$variant = ProductVariant::find($id);
if (!$variant) {
    $_SESSION['error'] = "Không tìm thấy biến thể!";
    header("Location: /duan11/index.php?page=product_variants");
    exit();
}

// Sau đó mới sử dụng $variant

?>

<form action="/duan11/routes/ProductVariant.php?action=update" method="POST">
    <input type="hidden" name="id" value="<?php echo $variant['id']; ?>">

    <label>Sản phẩm:</label>
    <select name="product_id" id="product-select" required>
        <?php
        require_once(__DIR__ . '/../../../models/Product.php');
        $products = Product::all();
        foreach ($products as $product) {
            $selected = ($product['id'] == $variant['product_id']) ? 'selected' : '';
            echo "<option value='" . $product['id'] . "' " . $selected . ">" . $product['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label>Size:</label>
    <select name="size_id[]" id="size-select" multiple required>
        <?php
        require_once(__DIR__ . '/../../../models/Size.php');
        $sizes = Size::all();
        $currentSizes = explode(',', $variant['size_id']); // Giả sử size_id được lưu dạng chuỗi phân cách bằng dấu phẩy
        foreach ($sizes as $size) {
            $selected = in_array($size['id'], $currentSizes) ? 'selected' : '';
            echo "<option value='" . $size['id'] . "' " . $selected . ">" . $size['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label>Color:</label>
    <select name="color_id[]" id="color-select" multiple required>
        <?php
        require_once(__DIR__ . '/../../../models/Color.php');
        $colors = Color::all();
        $currentColors = explode(',', $variant['color_id']); // Giả sử color_id được lưu dạng chuỗi phân cách bằng dấu phẩy
        foreach ($colors as $color) {
            $selected = in_array($color['id'], $currentColors) ? 'selected' : '';
            echo "<option value='" . $color['id'] . "' " . $selected . ">" . $color['color_code'] . "</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Cập nhật</button>
</form>

<a href="/duan11/index.php?page=product_variants">← Quay lại danh sách</a>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Khởi tạo Choices cho các dropdown
        var productSelect = document.getElementById('product-select');
        var sizeSelect = document.getElementById('size-select');
        var colorSelect = document.getElementById('color-select');

        new Choices(productSelect, {
            removeItemButton: false,
            searchEnabled: true,
            itemSelectText: 'Chọn sản phẩm',
        });

        new Choices(sizeSelect, {
            removeItemButton: true,
            searchEnabled: true,
            itemSelectText: 'Chọn kích thước',
        });

        new Choices(colorSelect, {
            removeItemButton: true,
            searchEnabled: true,
            itemSelectText: 'Chọn màu',
        });
    });
</script>
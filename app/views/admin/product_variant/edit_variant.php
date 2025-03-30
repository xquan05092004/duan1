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

<?php
if (isset($_SESSION['error'])) {
    echo "<div style='color: red;'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>

<form action="/duan1web/duan11/routes/ProductVariant.php?action=update" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($variant['id']) ?>">

    <label>Product ID:</label>
    <input type="number" name="product_id" value="<?= htmlspecialchars($variant['product_id']) ?>" required><br><br>

    <label>Size:</label>
    <select name="size_id[]" id="size-select" multiple required>
        <?php
        $selected_sizes = explode(",", $variant['size_id']); // Assuming size_id are stored as a comma-separated list
        foreach ($sizes as $size) {
            $selected = in_array($size['id'], $selected_sizes) ? 'selected' : '';
            echo "<option value='" . $size['id'] . "' $selected>" . $size['name'] . "</option>";
        }
        ?>
    </select><br><br>

    <label>Color:</label>
    <select name="color_id[]" id="color-select" multiple required>
        <?php
        $selected_colors = explode(",", $variant['color_id']); // Assuming color_id are stored as a comma-separated list
        foreach ($colors as $color) {
            $selected = in_array($color['id'], $selected_colors) ? 'selected' : '';
            echo "<option value='" . $color['id'] . "' $selected>" . $color['color_code'] . "</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">Cập nhật</button>
</form>

<a href="/duan1web/duan11/index.php?page=product_variants">← Quay lại danh sách</a>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var sizeSelect = document.getElementById('size-select');
        var colorSelect = document.getElementById('color-select');

        // Initialize Choices.js for the multiple select elements
        new Choices(sizeSelect, {
            removeItemButton: true,
            searchEnabled: true,
            itemSelectText: 'Chọn kích thước',
            placeholder: true,
            placeholderValue: 'Chọn size',
        });

        new Choices(colorSelect, {
            removeItemButton: true,
            searchEnabled: true,
            itemSelectText: 'Chọn màu',
            placeholder: true,
            placeholderValue: 'Chọn màu',
        });
    });
</script>
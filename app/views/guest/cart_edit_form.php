<!-- cart_edit_form -->
<h2>Sửa sản phẩm trong giỏ hàng</h2>

<form method="POST">
    <p>
        <label>Số lượng:</label>
        <input type="number" name="quantity" value="<?= $cart['quantity'] ?>" min="1" required>
    </p>

    <p>
        <label>Màu sắc:</label>
        <select name="color">
            <?php foreach ($colors as $color): ?>
            <option value="<?= $color['id'] ?>" <?= $color['id'] == $cart['color'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($color['color_code']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </p>

    <p>
        <label>Size:</label>
        <select name="size">
            <?php foreach ($sizes as $size): ?>
            <option value="<?= $size['id'] ?>" <?= $size['id'] == $cart['size'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($size['name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </p>

    <button type="submit">Lưu thay đổi</button>
    <a href="index.php?page=view_cart">⬅️ Quay lại giỏ hàng</a>
</form>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Biến Thể Sản Phẩm</title>

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
    <style>
        .color-preview {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
            vertical-align: middle;
        }

        .choices__list--multiple .choices__item {
            background-color: #007bff;
            border: 1px solid #006fe6;
        }

        .error-message {
            color: red;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Thêm Biến Thể Sản Phẩm</h2>

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form id="variantForm" action="routes/ProductVariant.php?action=store" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="product-select" class="form-label">Sản phẩm:</label>
                                <select name="product_id" id="product-select" class="form-select" required>
                                    <option value="">Chọn sản phẩm</option>
                                    <?php
                                    require_once(__DIR__ . '/../../../models/Product.php');
                                    $products = Product::all();
                                    foreach ($products as $product) {
                                        echo "<option value='" . $product['id'] . "'>" . $product['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn sản phẩm</div>
                            </div>

                            <div class="mb-3">
                                <label for="size-select" class="form-label">Size:</label>
                                <select name="size_id[]" id="size-select" multiple required>
                                    <?php
                                    require_once(__DIR__ . '/../../../models/Size.php');
                                    $sizes = Size::all();
                                    foreach ($sizes as $size) {
                                        echo "<option value='" . $size['id'] . "'>" . $size['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn ít nhất một size</div>
                            </div>

                            <div class="mb-3">
                                <label for="color-select" class="form-label">Màu sắc:</label>
                                <select name="color_id[]" id="color-select" multiple required>
                                    <?php
                                    require_once(__DIR__ . '/../../../models/Color.php');
                                    $colors = Color::all();
                                    foreach ($colors as $color) {
                                        echo "<option value='" . $color['id'] . "' data-color='" . $color['color_code'] . "'>"
                                            . $color['color_code'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn ít nhất một màu</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="index.php?page=product_variants" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Thêm biến thể
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Khởi tạo Choices.js cho các select
            const productSelect = new Choices('#product-select', {
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                placeholderValue: 'Chọn sản phẩm'
            });

            const sizeSelect = new Choices('#size-select', {
                removeItemButton: true,
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                placeholderValue: 'Chọn size'
            });

            const colorSelect = new Choices('#color-select', {
                removeItemButton: true,
                searchEnabled: true,
                itemSelectText: '',
                placeholder: true,
                placeholderValue: 'Chọn màu sắc',
                callbackOnCreateTemplates: function(template) {
                    return {
                        item: (classNames, data) => {
                            return template(`
                                <div class="${classNames.item} ${data.highlighted ? classNames.highlightedState : classNames.itemSelectable}" data-item data-id="${data.id}" data-value="${data.value}">
                                    <span class="color-preview" style="background-color: ${data.value}"></span>
                                    ${data.label}
                                </div>
                            `);
                        },
                        choice: (classNames, data) => {
                            return template(`
                                <div class="${classNames.item} ${classNames.itemChoice} ${data.disabled ? classNames.itemDisabled : classNames.itemSelectable}" data-select-text="${this.config.itemSelectText}" data-choice ${data.disabled ? 'data-choice-disabled aria-disabled="true"' : 'data-choice-selectable'} data-id="${data.id}" data-value="${data.value}">
                                    <span class="color-preview" style="background-color: ${data.value}"></span>
                                    ${data.label}
                                </div>
                            `);
                        }
                    };
                }
            });

            // Form validation
            const form = document.getElementById('variantForm');
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    </script>
</body>

</html>
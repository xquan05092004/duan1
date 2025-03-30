<?php
// app/views/admin/product_variant/product_variants.php

require_once(__DIR__ . '/../../../models/ProductVariant.php');
require_once(__DIR__ . '/../../../models/Size.php');
require_once(__DIR__ . '/../../../models/Color.php');

// Fetch product variants with sizes and colors
$query = "SELECT pv.id,   
                 pv.product_id,
                 p.name AS product_name,
                 GROUP_CONCAT(DISTINCT s.name ORDER BY s.name ASC) AS sizes,
                 GROUP_CONCAT(DISTINCT c.color_code ORDER BY c.color_code ASC) AS colors
          FROM product_variants pv
          JOIN products p ON pv.product_id = p.id
          JOIN sizes s ON pv.size_id = s.id
          JOIN colors c ON pv.color_id = c.id
          GROUP BY pv.id";

$db = new Database(); // Tạo một thể hiện của Database
$variants = $db->runQuery($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Biến Thể Sản Phẩm</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Filter functionality for each column
            $('#filter-id').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('#productTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(1)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });

            $('#filter-name').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('#productTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(2)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });

            $('#filter-size').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('#productTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(3)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });

            $('#filter-color').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('#productTable tbody tr').filter(function() {
                    $(this).toggle($(this).find('td:nth-child(4)').text().toLowerCase().indexOf(
                        value) > -1);
                });
            });
        });
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php" class="nav-link">Trang Chủ</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?page=product_variants" class="nav-link">Quản lý Biến Thể Sản Phẩm</a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="../../index3.html" class="brand-link">
                <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <div class="nav-item menu-open">
                            <a href="index.php" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Trang Chủ</p>
                            </a>
                        </div>
                        <li class="nav-item">
                            <a href="index.php?page=categories" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Danh Mục</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=product" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>Sản phẩm</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=donhang" class="nav-link">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Đơn hàng</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=user" class="nav-link">
                                <i class="nav-icon fas fa-tree"></i>
                                <p>Tài khoản</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Quản lý Biến Thể Sản Phẩm</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <a href="index.php?page=add_variant" class="btn btn-success mb-3">➕ Thêm biến thể mới</a>

                    <table class="table table-bordered table-hover bg-white" id="productTable">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID
                                </th>
                                <th>Sản phẩm <input type="text" id="filter-name" placeholder="Tìm sản phẩm"
                                        style="width: 150px;" /></th>
                                <th>Size <input type="text" id="filter-size" placeholder="Tìm size"
                                        style="width: 80px;" /></th>
                                <th>Màu sắc <input type="text" id="filter-color" placeholder="Tìm màu sắc"
                                        style="width: 100px;" /></th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($variants as $variant): ?>
                                <tr>
                                    <td><?= $variant['id'] ?></td>
                                    <td><?= $variant['product_name'] ?></td>
                                    <td><?= $variant['sizes'] ?></td>
                                    <td><?= $variant['colors'] ?></td>
                                    <td>
                                        <a href="index.php?page=edit_variant&id=<?= $variant['id'] ?>"
                                            class="btn btn-sm btn-warning">Sửa</a>
                                        <a href="routes/ProductVariant.php?action=delete&id=<?= $variant['id'] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0-rc
            </div>
            <strong>Copyright &copy; 2014-2020 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
</body>

</html>
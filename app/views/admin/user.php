<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // MySQL username
$password = "";     // MySQL password (empty for XAMPP)
$dbname = "clothing_store"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Query to select users with role 'user'
$query = "SELECT * FROM users WHERE role = 'user'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | DataTables</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="assets/index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->
      <form class="form-inline ml-3">
        <div class="input-group input-group-sm">
          <input class="form-control form-control-navbar" type="search" placeholder="Search"
            aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>
    </nav>

    <!-- Main Sidebar Container -->
    <!-- Phần Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../../index3.html" class="brand-link">
        <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="index.php" class="d-block">Admin User</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search"
              aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
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
            <li class="nav-item">
              <a href="index.php?page=binhluan" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>Bình luận</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/duan11/routes/User.php?action=logout" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Đăng xuất</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Quản lý tài khoản</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">DataTables</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>

                        <th>Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo $row['name']; ?></td>
                          <td><?php echo $row['phone']; ?></td>
                          <td><?php echo $row['email']; ?></td>
                          <td><?php echo $row['address']; ?></td>
                          <td><?php echo $row['created_at']; ?></td>
                          <td>
                            <button class="btn btn-warning btn-sm" data-toggle="modal"
                              data-target="#editModal<?php echo $row['id']; ?>">
                              Sửa
                            </button>
                            <a href="index.php?page=delete_customer&id=<?php echo $row['id']; ?>"
                              class="btn btn-danger btn-sm"
                              onclick="return confirm('Bạn có chắc chắn muốn xóa không?');">Xóa</a>
                          </td>
                        </tr>

                        <!-- Modal for editing customer information -->
                        <div class="modal fade" id="editModal<?php echo $row['id']; ?>"
                          tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                          aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Chỉnh sửa thông
                                  tin khách hàng</h5>
                                <button type="button" class="close" data-dismiss="modal"
                                  aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="index.php?page=edit_customer" method="POST">
                                  <input type="hidden" name="id"
                                    value="<?php echo $row['id']; ?>">
                                  <div class="form-group">
                                    <label for="name">Tên khách hàng:</label>
                                    <input type="text" class="form-control" id="name"
                                      name="name" value="<?php echo $row['name']; ?>"
                                      required>
                                  </div>
                                  <div class="form-group">
                                    <label for="phone">Số điện thoại:</label>
                                    <input type="text" class="form-control" id="phone"
                                      name="phone"
                                      value="<?php echo $row['phone']; ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email"
                                      name="email"
                                      value="<?php echo $row['email']; ?>" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="address">Địa chỉ:</label>
                                    <input type="text" class="form-control" id="address"
                                      name="address"
                                      value="<?php echo $row['address']; ?>" required>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Lưu
                                      thay đổi</button>
                                    <button type="button" class="btn btn-secondary"
                                      data-dismiss="modal">Hủy</button>
                                  </div>
                                </form>

                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } ?>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
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

  <script src="assets/plugins/jquery/jquery.min.js"></script>
  <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="assets/plugins/jszip/jszip.min.js"></script>
  <script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
  <script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script src="assets/dist/js/adminlte.min.js"></script>

  <script>
    $(function() {
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

</body>

</html>
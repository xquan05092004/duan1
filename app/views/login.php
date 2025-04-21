<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="public/css/style.css">
    <style>
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2>Đăng nhập</h2>
            <form action="index.php?controller=auth&action=login" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="error-message">
                        <?php
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                        ?>
                    </div>
                <?php endif; ?>
                <button type="submit">Đăng nhập</button>
            </form>
            <p>Chưa có tài khoản? <a href="index.php?controller=auth&action=register">Đăng ký</a></p>
        </div>
    </div>
</body>

</html>
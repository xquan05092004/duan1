<?php
session_start();
require_once '../app/models/User.php';
require_once '../app/config/database.php';

$db = new Database(); // Khởi tạo database

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::login($db,$email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                header("Location: ../index.php"); // Redirect to main page
                exit;
            } else {
                // Store error message in session
                $_SESSION['login_error'] = "Tên đăng nhập hoặc mật khẩu không chính xác";
                header("Location: ../app/views/users/login.php?error");
                exit;
            }
        }
        break;  

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'address' => $_POST['address'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'role' => 'user',
            ];  

            $registrationResult = User::register($db,$data);

            if ($registrationResult['success']) {
                // Redirect to login with success message
                header("Location: ../app/views/users/login.php?registered");
                exit;
            } else {
                // Store errors in session to display on registration page
                $_SESSION['registration_errors'] = $registrationResult['errors'];
                header("Location: ../app/views/users/register.php");
                exit;
            }
        }
        break;

    case 'logout':
        session_destroy();
        unset($_SESSION['user']);
        header("Location: ../index.php"); // Chuyển về trang chính sau khi logout
        exit;

    default:
        echo "Không tìm thấy hành động phù hợp!";
        break;
}
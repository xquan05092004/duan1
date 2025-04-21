<?php
session_start();
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/User.php';

$action = $_GET['action'] ?? '';
$db = new Database();
$userModel = new User($db);

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kiểm tra trạng thái tài khoản trước
            $account = $userModel->getAccountByEmail($email);
            if ($account) {
                if ($account['status'] === 'inactive') {
                    $_SESSION['login_error'] = 'Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên để được hỗ trợ.';
                    header('Location: ../app/views/users/login.php');
                    exit;
                }

                // Nếu tài khoản active, tiếp tục kiểm tra đăng nhập
                $user = User::login($db, $email, $password);
                if ($user) {
                    $_SESSION['user'] = $user;
                    if ($user['role'] === 'admin') {
                        header('Location: ../index.php?page=dashboard');
                    } else {
                        header('Location: ../index.php');
                    }
                    exit;
                } else {
                    $_SESSION['login_error'] = 'Email hoặc mật khẩu không chính xác';
                    header('Location: ../app/views/users/login.php');
                    exit;
                }
            } else {
                $_SESSION['login_error'] = 'Email hoặc mật khẩu không chính xác';
                header('Location: ../app/views/users/login.php');
                exit;
            }
        }
        break;

    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = User::register($db, $_POST);
            if ($result['success']) {
                $_SESSION['success'] = 'Đăng ký thành công';
                header('Location: ../index.php?page=login');
            } else {
                $_SESSION['error'] = implode(', ', $result['errors']);
                header('Location: ../index.php?page=register');
            }
            exit;
        }
        break;

    case 'logout':
        session_destroy();
        header('Location: ../index.php');
        break;

    case 'deactivate':
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($userModel->deactivateUser($id)) {
                $_SESSION['success'] = 'Đã khóa tài khoản thành công';
            } else {
                $_SESSION['error'] = 'Không thể khóa tài khoản';
            }
        }
        header('Location: ../index.php?page=user');
        break;

    case 'activate':
        $id = $_GET['id'] ?? null;
        if ($id) {
            if ($userModel->updateStatus($id, 'active')) {
                $_SESSION['success'] = 'Đã mở khóa tài khoản thành công';
            } else {
                $_SESSION['error'] = 'Không thể mở khóa tài khoản';
            }
        }
        header('Location: ../index.php?page=user');
        break;

    default:
        header('Location: ../index.php');
        break;
}
exit;

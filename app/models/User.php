<?php
require_once __DIR__ . '/../config/database.php';

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAccountByEmail($email)
    {
        try {
            $stmt = $this->db->runQuery("SELECT * FROM users WHERE email = ?", [$email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get account error: " . $e->getMessage());
            return false;
        }
    }

    public static function login($db, $email, $password)
    {
        try {
            // Kiểm tra email và lấy thông tin user
            $stmt = $db->runQuery("SELECT * FROM users WHERE email = ?", [$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return false;
            }

            // Kiểm tra mật khẩu
            if (!password_verify($password, $user['password'])) {
                return false;
            }

            // Nếu mọi thứ ok, trả về thông tin user (đã loại bỏ password)
            unset($user['password']);
            return $user;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $_SESSION['login_error'] = 'Có lỗi xảy ra, vui lòng thử lại sau';
            return false;
        }
    }

    public static function register($db, $data)
    {
        $errors = [];

        if (empty($data['name'])) {
            $errors[] = "Name is required";
        }
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email";
        }
        if (empty($data['password']) || strlen($data['password']) < 6) {
            $errors[] = "Password must be at least 6 characters";
        }

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $existingUser = $db->runQuery("SELECT COUNT(*) FROM users WHERE email = ?", [$data['email']])->fetchColumn();
            if ($existingUser > 0) {
                return ['success' => false, 'errors' => ['Email already exists']];
            }

            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $query = "INSERT INTO users (name, email, password, phone, address, role, status, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, 'active', NOW())";
            $result = $db->runQuery($query, [
                htmlspecialchars($data['name']),
                $data['email'],
                $hashedPassword,
                htmlspecialchars($data['phone'] ?? ''),
                htmlspecialchars($data['address'] ?? ''),
                $data['role'] ?? 'user'
            ]);

            return ['success' => $result, 'errors' => []];
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            return ['success' => false, 'errors' => ['Database error occurred']];
        }
    }

    public function updateStatus($userId, $status)
    {
        try {
            $query = "UPDATE users SET status = ? WHERE id = ?";
            $stmt = $this->db->runQuery($query, [$status, $userId]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Update user status error: " . $e->getMessage());
            return false;
        }
    }

    public function deactivateUser($userId)
    {
        return $this->updateStatus($userId, 'inactive');
    }
}

<?php
require_once __DIR__ . '/../config/database.php';

class User
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public static function login($db, $email, $password)
    {
        $stmt = $db->runQuery("SELECT * FROM users WHERE email = ?", [$email]);

        if ($stmt) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']);
                return $user;
            }
        }
        return false;
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
            $query = "INSERT INTO users (name, email, password, phone, address, role, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
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
}

<?php
// app/models/Color.php
require_once __DIR__ . '/../config/database.php';

class Color
{
    // Lấy tất cả các màu từ cơ sở dữ liệu
    public static function all()
    {
        $db = new Database(); // Tạo một thể hiện của Database
        $query = "SELECT * FROM colors";
        return $db->runQuery($query);
    }
    
    
}

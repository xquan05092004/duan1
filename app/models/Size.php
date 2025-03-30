<?php
// app/models/Size.php
require_once __DIR__ . '/../config/database.php';

class Size
{
    // Lấy tất cả các size từ cơ sở dữ liệu
    public static function all()
    {
        $db = new Database(); // Giả sử Database có phương thức runQuery
        $query = "SELECT * FROM sizes";
        return $db->runQuery($query);
    }
}

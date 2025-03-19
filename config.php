<?php
$host = "localhost";  // Địa chỉ server
$user = "root";       // Tài khoản MySQL (mặc định của XAMPP là root)
$pass = "";           // Mật khẩu (mặc định trống)
$dbname = "test1"; // Tên database

$conn = new mysqli($host, $user, $pass, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>

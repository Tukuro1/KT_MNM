<?php
include 'config.php';
session_start();

if (!isset($_SESSION['MaSV'])) {
    echo "<script>alert('Bạn cần đăng nhập để đăng ký!'); window.location.href='login.php';</script>";
    exit;
}

$MaSV = $_SESSION['MaSV'];
$MaDK = $_POST['MaDK'];
$hocphans = isset($_POST['hocphan']) ? $_POST['hocphan'] : [];

// Kiểm tra nếu chưa chọn học phần nào
if (empty($hocphans)) {
    echo "<script>alert('Bạn chưa chọn học phần nào!'); window.location.href='dangky.php';</script>";
    exit;
}

// Lưu các học phần vào ChiTietDangKy
foreach ($hocphans as $MaHP) {
    $insertCTDK = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
    $stmt = $conn->prepare($insertCTDK);
    $stmt->bind_param("is", $MaDK, $MaHP);
    $stmt->execute();
}

echo "<script>alert('Đăng ký thành công!'); window.location.href='hocphandadangky.php';</script>";
?>

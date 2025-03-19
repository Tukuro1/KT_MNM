<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quản lý Sinh viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Quản lý Sinh viên</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="create.php">Thêm Sinh viên</a></li>
                <li class="nav-item"><a class="nav-link" href="dangky.php">Đăng ký học phần</a></li>
                <li class="nav-item"><a class="nav-link" href="hocphandadangky.php">Học phần đã đăng ký</a></li>
                <li><a href="logout.php">Đăng Xuất</a></li>

            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['MaSV'])): ?>
                    <li class="nav-item"><a class="nav-link text-white" href="logout.php">Đăng xuất</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link text-white" href="login.php">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-4">

<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maSV = $_POST['MaSV'];

    // Kiểm tra xem Mã SV có tồn tại trong database không
    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$maSV'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['MaSV'] = $maSV;
        header("Location: index.php"); // Chuyển hướng sau khi đăng nhập thành công
        exit();
    } else {
        $error = "Mã sinh viên không tồn tại!";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h2 class="text-center">ĐĂNG NHẬP</h2>
    
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <label for="MaSV">Mã SV</label>
            <input type="text" class="form-control" id="MaSV" name="MaSV" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng Nhập</button>
    </form>

    <br>
    <a href="index.php">Back to List</a>
</div>

<?php include 'footer.php'; ?>

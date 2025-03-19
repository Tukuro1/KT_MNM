<?php 
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM SinhVien WHERE MaSV='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Xóa thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

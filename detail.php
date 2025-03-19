<?php 
include 'config.php'; 
include 'header.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT sv.*, n.TenNganh 
            FROM SinhVien sv 
            JOIN NganhHoc n ON sv.MaNganh = n.MaNganh 
            WHERE sv.MaSV = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<h2 class="text-center">Chi tiết Sinh viên</h2>
<table class="table table-bordered">
    <tr><th>Mã SV</th><td><?php echo $row['MaSV']; ?></td></tr>
    <tr><th>Họ Tên</th><td><?php echo $row['HoTen']; ?></td></tr>
    <tr><th>Giới Tính</th><td><?php echo $row['GioiTinh']; ?></td></tr>
    <tr><th>Ngày Sinh</th><td><?php echo $row['NgaySinh']; ?></td></tr>
    <tr><th>Ngành Học</th><td><?php echo $row['TenNganh']; ?></td></tr>
    <tr><th>Ảnh</th><td><img src="uploads/<?php echo $row['Hinh']; ?>" width="100"></td></tr>
</table>
<a href="index.php" class="btn btn-secondary">Quay lại</a>

<?php include 'footer.php'; ?>

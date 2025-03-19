<?php
include 'config.php';
include 'header.php';

$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>

<h2 class="text-center">Danh Sách Sinh Viên</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Ngành</th>
            <th>Hành Động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['MaSV']; ?></td>
                <td><?php echo $row['HoTen']; ?></td>
                <td><?php echo $row['GioiTinh']; ?></td>
                <td><?php echo $row['NgaySinh']; ?></td>
                <td><?php echo $row['MaNganh']; ?></td>
                <td>
                    <a href="detail.php?id=<?php echo $row['MaSV']; ?>" class="btn btn-info">Chi Tiết</a>
                    <a href="edit.php?id=<?php echo $row['MaSV']; ?>" class="btn btn-warning">Sửa</a>
                    <a href="delete.php?id=<?php echo $row['MaSV']; ?>" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>

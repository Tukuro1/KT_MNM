<?php
include 'config.php';
include 'header.php';

$sql = "SELECT SV.*, NH.TenNganh FROM SinhVien SV 
        LEFT JOIN NganhHoc NH ON SV.MaNganh = NH.MaNganh";
$result = $conn->query($sql);
?>

<h2 class="text-center">Danh Sách Sinh Viên</h2>
<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>Hình Ảnh</th>
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
                <td>
                    <?php 
                        // Kiểm tra nếu có ảnh thì lấy từ thư mục img/, nếu không có thì dùng ảnh mặc định
                        $imagePath = !empty($row['HinhAnh']) ? 'img/' . $row['HinhAnh'] : 'img/default.png'; 
                    ?>
                    <img src="<?php echo $imagePath; ?>" width="80" height="80" class="rounded">
                </td>
                <td><?php echo htmlspecialchars($row['MaSV']); ?></td>
                <td><?php echo htmlspecialchars($row['HoTen']); ?></td>
                <td><?php echo htmlspecialchars($row['GioiTinh']); ?></td>
                <td><?php echo htmlspecialchars($row['NgaySinh']); ?></td>
                <td><?php echo htmlspecialchars($row['TenNganh']); ?></td>
                <td>
                    <a href="detail.php?id=<?php echo $row['MaSV']; ?>" class="btn btn-info btn-sm">Chi Tiết</a>
                    <a href="edit.php?id=<?php echo $row['MaSV']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="delete.php?id=<?php echo $row['MaSV']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">Xóa</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>

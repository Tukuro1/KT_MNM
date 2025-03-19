<?php 
include 'config.php'; 
include 'header.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST['HoTen'];
    $gioitinh = $_POST['GioiTinh'];
    $ngaysinh = $_POST['NgaySinh'];
    $manganh = $_POST['MaNganh'];

    $sql = "UPDATE SinhVien SET HoTen='$hoten', GioiTinh='$gioitinh', NgaySinh='$ngaysinh', MaNganh='$manganh' WHERE MaSV='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cập nhật thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<h2 class="text-center">Sửa Sinh Viên</h2>
<form method="POST">
    <label>Họ Tên:</label>
    <input type="text" name="HoTen" value="<?php echo $row['HoTen']; ?>" required class="form-control">
    
    <label>Giới Tính:</label>
    <select name="GioiTinh" class="form-control">
        <option value="Nam" <?php if ($row['GioiTinh'] == "Nam") echo "selected"; ?>>Nam</option>
        <option value="Nữ" <?php if ($row['GioiTinh'] == "Nữ") echo "selected"; ?>>Nữ</option>
    </select>
    
    <label>Ngày Sinh:</label>
    <input type="date" name="NgaySinh" value="<?php echo $row['NgaySinh']; ?>" required class="form-control">
    
    <label>Ngành Học:</label>
    <select name="MaNganh" class="form-control">
        <?php 
        $result = $conn->query("SELECT * FROM NganhHoc");
        while ($row_nganh = $result->fetch_assoc()) {
            $selected = ($row['MaNganh'] == $row_nganh['MaNganh']) ? "selected" : "";
            echo "<option value='{$row_nganh['MaNganh']}' $selected>{$row_nganh['TenNganh']}</option>";
        }
        ?>
    </select>
    
    <button type="submit" class="btn btn-success mt-3">Cập nhật</button>
</form>

<?php include 'footer.php'; ?>

<?php include 'config.php'; ?>
<?php include 'header.php'; ?>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masv = $_POST['MaSV'];
    $hoten = $_POST['HoTen'];
    $gioitinh = $_POST['GioiTinh'];
    $ngaysinh = $_POST['NgaySinh'];
    $manganh = $_POST['MaNganh'];

    // Xử lý upload hình ảnh
    $target_dir = "uploads/"; // Thư mục lưu ảnh
    $target_file = $target_dir . basename($_FILES["HinhAnh"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra định dạng file
    $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowTypes)) {
        echo "<script>alert('Chỉ chấp nhận file JPG, JPEG, PNG, GIF!'); window.history.back();</script>";
        exit;
    }

    // Di chuyển file upload vào thư mục
    if (move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $target_file)) {
        $imagePath = $target_file;
    } else {
        $imagePath = "uploads/default.png"; // Nếu lỗi thì dùng ảnh mặc định
    }

    // Chèn dữ liệu vào database
    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh, HinhAnh) 
            VALUES ('$masv', '$hoten', '$gioitinh', '$ngaysinh', '$manganh', '$imagePath')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thêm sinh viên thành công!'); window.location='index.php';</script>";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<h2 class="text-center">Thêm Sinh Viên</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Mã SV:</label>
    <input type="text" name="MaSV" required class="form-control">
    
    <label>Họ Tên:</label>
    <input type="text" name="HoTen" required class="form-control">
    
    <label>Giới Tính:</label>
    <select name="GioiTinh" class="form-control">
        <option value="Nam">Nam</option>
        <option value="Nữ">Nữ</option>
    </select>
    
    <label>Ngày Sinh:</label>
    <input type="date" name="NgaySinh" required class="form-control">

    <label>Ngành Học:</label>
    <select name="MaNganh" class="form-control">
        <?php 
        $result = $conn->query("SELECT * FROM NganhHoc");
        while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['MaNganh']}'>{$row['TenNganh']}</option>";
        }
        ?>
    </select>

    <label>Hình Ảnh:</label>
    <input type="file" name="HinhAnh" accept="image/*" required class="form-control">

    <button type="submit" class="btn btn-primary mt-3">Thêm</button>
</form>

<?php include 'footer.php'; ?>

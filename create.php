<?php 
include 'config.php'; 
include 'header.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $masv = $_POST['MaSV'];
    $hoten = $_POST['HoTen'];
    $gioitinh = $_POST['GioiTinh'];
    $ngaysinh = $_POST['NgaySinh'];
    $manganh = $_POST['MaNganh'];

    // Thư mục lưu ảnh
    $target_dir = "img/"; 
    $imagePath = "img/default.png"; // Ảnh mặc định

    // Xử lý upload hình ảnh
    if (!empty($_FILES["HinhAnh"]["name"])) {
        $file_name = time() . "_" . basename($_FILES["HinhAnh"]["name"]); // Đổi tên file tránh trùng lặp
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowTypes = ['jpg', 'jpeg', 'png', 'gif'];

        // Kiểm tra định dạng file
        if (in_array($imageFileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["HinhAnh"]["tmp_name"], $target_file)) {
                $imagePath = $target_file;
            } else {
                echo "<script>alert('Lỗi khi tải ảnh lên!'); window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Chỉ chấp nhận file JPG, JPEG, PNG, GIF!'); window.history.back();</script>";
            exit;
        }
    }

    // Chèn dữ liệu vào database
    $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, MaNganh, HinhAnh) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $masv, $hoten, $gioitinh, $ngaysinh, $manganh, $imagePath);

    if ($stmt->execute()) {
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
        <option value="Nam">Nam

<?php
include 'config.php';
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaSV'])) {
    echo "<script>alert('Bạn cần đăng nhập để đăng ký học phần!'); window.location.href='login.php';</script>";
    exit;
}

$MaSV = $_SESSION['MaSV'];

// Lấy danh sách học phần
$query = "SELECT * FROM HocPhan";
$result = $conn->query($query);

// Xử lý đăng ký học phần
if (isset($_GET['register'])) {
    $MaHP = $_GET['register'];

    // Kiểm tra xem sinh viên đã có mã đăng ký chưa
    $queryCheck = "SELECT MaDK FROM DangKy WHERE MaSV = ?";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bind_param("s", $MaSV);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows == 0) {
        // Nếu chưa có, tạo mã đăng ký mới
        $newMaDK = uniqid("DK");
        $insertDK = "INSERT INTO DangKy (MaDK, MaSV) VALUES (?, ?)";
        $stmtInsertDK = $conn->prepare($insertDK);
        $stmtInsertDK->bind_param("ss", $newMaDK, $MaSV);
        $stmtInsertDK->execute();
    } else {
        $row = $resultCheck->fetch_assoc();
        $newMaDK = $row['MaDK'];
    }

    // Kiểm tra xem học phần đã được đăng ký chưa
    $queryCheckHP = "SELECT * FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?";
    $stmtCheckHP = $conn->prepare($queryCheckHP);
    $stmtCheckHP->bind_param("ss", $newMaDK, $MaHP);
    $stmtCheckHP->execute();
    $resultCheckHP = $stmtCheckHP->get_result();

    if ($resultCheckHP->num_rows == 0) {
        // Thêm học phần vào bảng ChiTietDangKy
        $insertQuery = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bind_param("ss", $newMaDK, $MaHP);
        $stmtInsert->execute();
        echo "<script>alert('Đăng ký học phần thành công!'); window.location.href='dangky.php';</script>";
    } else {
        echo "<script>alert('Bạn đã đăng ký học phần này trước đó!');</script>";
    }
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h2 class="text-center mt-4">DANH SÁCH HỌC PHẦN</h2>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Mã Học Phần</th>
                <th>Tên Học Phần</th>
                <th>Số Tín Chỉ</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['MaHP']); ?></td>
                    <td><?php echo htmlspecialchars($row['TenHP']); ?></td>
                    <td><?php echo htmlspecialchars($row['SoTinChi']); ?></td>
                    <td>
                        <a href="dangky.php?register=<?php echo $row['MaHP']; ?>" class="btn btn-success btn-sm">Đăng Ký</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>

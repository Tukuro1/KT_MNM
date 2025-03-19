<?php
include 'config.php';
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['MaSV'])) {
    echo "<script>alert('Bạn cần đăng nhập để xem học phần đã đăng ký!'); window.location.href='login.php';</script>";
    exit;
}

$MaSV = $_SESSION['MaSV'];

// Lấy thông tin sinh viên
$querySV = "SELECT MaSV, HoTen FROM SinhVien WHERE MaSV = ?";
$stmtSV = $conn->prepare($querySV);
$stmtSV->bind_param("s", $MaSV);
$stmtSV->execute();
$resultSV = $stmtSV->get_result();
$svData = $resultSV->fetch_assoc();

// Lấy Mã Đăng Ký mới nhất của sinh viên
$queryMaDK = "SELECT MaDK FROM DangKy WHERE MaSV = ? ORDER BY MaDK DESC LIMIT 1";
$stmtMaDK = $conn->prepare($queryMaDK);
$stmtMaDK->bind_param("s", $MaSV);
$stmtMaDK->execute();
$resultMaDK = $stmtMaDK->get_result();
$maDKData = $resultMaDK->fetch_assoc();
$MaDK = $maDKData['MaDK'] ?? null; // Kiểm tra nếu không có mã đăng ký

$totalSubjects = 0;
$totalCredits = 0;
$hocPhanList = [];

if ($MaDK) {
    // Lấy danh sách học phần đã đăng ký
    $query = "SELECT HP.MaHP, HP.TenHP, HP.SoTinChi 
              FROM HocPhan HP 
              JOIN ChiTietDangKy CT ON HP.MaHP = CT.MaHP 
              WHERE CT.MaDK = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $MaDK); // Đổi từ "i" -> "s"
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $hocPhanList[] = $row;
        $totalSubjects++;
        $totalCredits += $row['SoTinChi'];
    }
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <h2 class="text-center mt-4">Học Phần Đã Đăng Ký</h2>
    
    <p><strong>Mã SV:</strong> <?php echo htmlspecialchars($svData['MaSV']); ?></p>
    <p><strong>Họ Tên:</strong> <?php echo htmlspecialchars($svData['HoTen']); ?></p>

    <?php if ($MaDK && count($hocPhanList) > 0) { ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã Học Phần</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hocPhanList as $row) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['MaHP']); ?></td>
                        <td><?php echo htmlspecialchars($row['TenHP']); ?></td>
                        <td><?php echo htmlspecialchars($row['SoTinChi']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p><strong>Số học phần:</strong> <?php echo $totalSubjects; ?></p>
        <p><strong>Tổng số tín chỉ:</strong> <?php echo $totalCredits; ?></p>
    <?php } else { ?>
        <p class="text-danger">Bạn chưa đăng ký học phần nào!</p>
    <?php } ?>

    <a href="dangky.php?new_register=true" class="btn btn-success">Lưu Đăng Ký Mới</a>
</div>

<?php include 'footer.php'; ?>

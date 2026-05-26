<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "btl_database";

// Khởi tạo kết nối
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}
// Đồng bộ bảng mã UTF-8 tránh lỗi hiển thị tiếng Việt tiếng có dấu
mysqli_set_charset($conn, "utf8mb4");

// Cấu hình các cột (fields) và khóa chính (pk) của từng bảng chính xác theo file thiết kế
$tables_config = [
    'HOC_SINH' => [
        'pk' => 'maSinhVien',
        'title' => 'Học Sinh',
        'fields' => ['maSinhVien', 'maNganh', 'tenSinhVien', 'ngaySinh', 'gioiTinh']
    ],
    'DANH_GIA' => [
        'pk' => 'maDot',
        'title' => 'Đợt Đánh Giá',
        'fields' => ['maDot', 'tenDot', 'hocKi', 'namHoc', 'ngayDanhGia']
    ],
    'DIEM_REN_LUYEN' => [
        'pk' => 'maDanhGia',
        'title' => 'Điểm Rèn Luyện',
        'fields' => ['maDanhGia', 'maSinhVien', 'maDot', 'diemRenLuyen', 'xepLoai']
    ],
    'MINH_CHUNG' => [
        'pk' => 'maMinhChung',
        'title' => 'Minh Chứng',
        'fields' => ['maMinhChung', 'maDanhGia', 'noiDung', 'diemCong']
    ]
];
?>
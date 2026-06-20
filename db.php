<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "btl_database";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8mb4");

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
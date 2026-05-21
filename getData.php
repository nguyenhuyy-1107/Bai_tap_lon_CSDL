<?php
header('Content-Type: application/json');
include 'connect.php';

$table = $_GET['table'] ?? '';
$allowed_tables = ['hoc_sinh', 'danh_gia', 'diem_ren_luyen', 'minh_chung'];

if (!in_array($table, $allowed_tables)) {
    echo json_encode(["success" => false, "message" => "Bảng dữ liệu không tồn tại!"]);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM $table");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_NUM); 

    $headers = [];
    for ($i = 0; $i < $stmt->columnCount(); $i++) {
        $meta = $stmt->getColumnMeta($i);
        $headers[] = strtoupper($meta['name']); 
    }

    echo json_encode([
        "success" => true,
        "headers" => $headers,
        "rows" => $rows
    ]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Lỗi truy vấn: " . $e->getMessage()]);
}
?>
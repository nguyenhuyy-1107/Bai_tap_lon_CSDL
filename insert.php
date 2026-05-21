<?php
header('Content-Type: application/json');
include 'connect.php';

$input = json_decode(file_get_contents('php://input'), true);
$table = $input['table'] ?? '';
$data = $input['data'] ?? [];

if (empty($table) || empty($data)) {
    echo json_encode(["success" => false, "message" => "Dữ liệu nhập vào không hợp lệ!"]);
    exit();
}

try {
    $columns = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));
    $values = array_values($data);

    $stmt = $conn->prepare("INSERT INTO $table ($columns) VALUES ($placeholders)");
    $stmt->execute($values);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Không thể thêm dữ liệu: " . $e->getMessage()]);
}
?>
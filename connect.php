<?php
$host = "localhost";
$dbname = "btl_database";
$username = "root"; // Mặc định của XAMPP/Laragon
$password = "";     // Mặc định của XAMPP để trống

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(["success" => false, "message" => "Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage()]);
    exit();
}
?>
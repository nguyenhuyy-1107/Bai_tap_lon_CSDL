<?php
require_once 'db.php';

$message = "";

$current_table = isset($_GET['table']) && array_key_exists($_GET['table'], $tables_config) ? $_GET['table'] : 'HOC_SINH';
$config = $tables_config[$current_table];
$pk_field = $config['pk'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'add' || $action === 'edit') {
        $fields_sql = [];
        $values_sql = [];
        $update_sql = [];
        
        foreach ($config['fields'] as $field) {
            $val = isset($_POST[$field]) ? $conn->real_escape_string($_POST[$field]) : '';
            $fields_sql[] = $field;
            $values_sql[] = "'$val'";
            if ($field !== $pk_field) {
                $update_sql[] = "$field = '$val'";
            }
        }
        
        if ($action === 'add') {
            $sql = "INSERT INTO $current_table (" . implode(',', $fields_sql) . ") VALUES (" . implode(',', $values_sql) . ")";
        } else {
            $pk_val = $conn->real_escape_string($_POST[$pk_field]);
            $sql = "UPDATE $current_table SET " . implode(',', $update_sql) . " WHERE $pk_field = '$pk_val'";
        }
        
        if ($conn->query($sql)) {
            $message = "Thực hiện cập nhật dữ liệu thành công!";
        } else {
            $message = "Lỗi hệ thống: " . $conn->error;
        }
    } 
    elseif ($action === 'delete') {
        $pk_val = $conn->real_escape_string($_POST['id']);
        $sql = "DELETE FROM $current_table WHERE $pk_field = '$pk_val'";
        
        if ($conn->query($sql)) {
            $message = "Xóa bản ghi khỏi hệ thống thành công!";
        } else {
            $message = "Không thể xóa do liên kết ràng buộc: " . $conn->error;
        }
    }
}

$query = "SELECT * FROM $current_table";
$result = $conn->query($query);
?>
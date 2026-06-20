<?php
session_start();
require_once 'db.php';

// Chuyển hướng vào trang chủ
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taiKhoan = $conn->real_escape_string($_POST['taiKhoan']);
    $matKhau = $_POST['matKhau']; 

    if (!empty($taiKhoan) && !empty($matKhau)) {
        $sql = "SELECT * FROM TAI_KHOAN WHERE taiKhoan = '$taiKhoan' AND matKhau = '$matKhau'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $_SESSION['user'] = $user_data['taiKhoan'];
            $_SESSION['user_name'] = $user_data['tenHienThi'];
            
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Tài khoản hoặc mật khẩu không chính xác!";
        }
    } else {
        $error_message = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hệ Thống Quản Lý</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f6f9;
        }
        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #2d3748;
        }
        .login-error {
            background-color: #fed7d7;
            color: #c53030;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            border: 1px solid #f5c6cb;
        }
        .login-card .form-group {
            margin-bottom: 20px;
        }
        .login-card .btn-submit {
            background-color: #2b6cb0;
            color: white;
            margin-top: 10px;
        }
        .login-card .btn-submit:hover {
            background-color: #1a4975;
        }
    </style>
</head>
<body class="login-body">

    <div class="login-card">
        <h2>Đăng Nhập Hệ Thống</h2>
        
        <?php if ($error_message != ""): ?>
            <div class="login-error">❌ <?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="taiKhoan">Tài khoản</label>
                <input type="text" name="taiKhoan" id="taiKhoan" required placeholder="Nhập tài khoản...">
            </div>
            <div class="form-group">
                <label for="matKhau">Mật khẩu</label>
                <input type="password" name="matKhau" id="matKhau" required placeholder="Nhập mật khẩu...">
            </div>
            <button type="submit" class="btn btn-submit">Đăng nhập</button>
        </form>
    </div>

</body>
</html>
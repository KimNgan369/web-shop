<?php
session_start();

// Include necessary files
include "../dao/pdo.php";
include "../dao/user.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $user = checkuser($email, $password);
    
    if (isset($user) && is_array($user) && count($user) > 0) {
        extract($user);
        if ($role == 'admin') {
            $_SESSION['role'] = 'admin';
            $_SESSION['s_user'] = $user;
            header("location: index.php");
            exit;
        } else {
            $tb = "Tài khoản này không có quyền đăng nhập trang quản trị!";
        }
    } else {
        $tb = "Tài khoản này không tồn tại. Hãy đăng nhập lại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: url('https://source.unsplash.com/1600x900/?fantasy,landscape') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .social-login button {
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .social-login img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="text-center">
            <div class="mb-3">
                <!-- Avatar placeholder -->
            </div>
            <h4>Log in</h4>
            <p>Don't have an account? <a href="index.php?pg=signup">Sign up</a></p>
        </div>
        <div class="d-flex align-items-center my-2">
            <hr class="flex-grow-1">
            <span class="mx-2">OR</span>
            <hr class="flex-grow-1">
        </div>
        
        <form action="login.php" method="POST">
            <div class="mb-3">
                <?php
                if (isset($_SESSION['tb_dangnhap']) && $_SESSION['tb_dangnhap']) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 8px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                            <i class="bi bi-exclamation-circle me-2"></i>' . htmlspecialchars($_SESSION['tb_dangnhap']) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    unset($_SESSION['tb_dangnhap']);
                }
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Your email</label>
                <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Your password</label>
                <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
            </div>
            <?php
            if (isset($tb) && $tb != "") {
                echo "<h3 style='color: red'>" . $tb . "</h3>";
            }
            ?>
            <div class="row">
                <input type="submit" class="btn btn-secondary w-100 mt-3" name="login" value="Đăng nhập">
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-outline-warning border-dark">
                    <a href="../index.php" class="text-black text-decoration-none">Về trang chủ</a>
                </button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
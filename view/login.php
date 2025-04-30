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
                <!--avata???-->
            </div>
            <h4>Log in</h4>
            <p>Don't have an account? <a href="index.php?pg=signup">Sign up</a></p>
        </div>
        <div class="social-login">
            <button class="btn btn-outline-danger w-100 mb-3 rounded-pill"> 
                <i class="bi bi-google me-2"></i> Log in with Google
            </button>
        </div>
        <div class="d-flex align-items-center my-2">
            <hr class="flex-grow-1">
            <span class="mx-2">OR</span>
            <hr class="flex-grow-1">
        </div>
        
        <form action="index.php?pg=login" method="POST">
            <div class="mb-3">
                <?php
                if (isset($_SESSION['tb_dangnhap']) && $_SESSION['tb_dangnhap']) {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert" style="border-radius: 8px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                            <i class="bi bi-exclamation-circle me-2"></i>' . htmlspecialchars($_SESSION['tb_dangnhap']) . '
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    unset($_SESSION['tb_dangnhap']); // Xóa thông báo sau khi hiển thị
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
            <div class="row">
                <input type="submit" class="btn btn-secondary w-100 mt-3" name="login" value="Đăng nhập">
            </div>
        </form>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
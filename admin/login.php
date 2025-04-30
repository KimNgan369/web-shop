<?php 
session_start(); 
ob_start(); 
include "models/pdo.php"; 
include "models/user.php"; 

$error = '';

if(isset($_POST['dangnhap'])) { 
    $user = $_POST['user']; 
    $pass = $_POST['pass']; 
    
    $role = checkuser($user, $pass); 
    
    if ($role !== null && $role !== 0) { 
        // Đăng nhập thành công
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $user;
        
        // Regenerate session ID để tăng cường bảo mật
        session_regenerate_id(true);
        
        if ($role == 1) { 
            header('Location: index.php'); 
        } else { 
            header('Location: login.php'); 
        }
        exit;
    } else { 
        $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    } 
} 
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Login Admin</title> 
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
        .error-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
            text-align: center;
        }
    </style> 
</head> 
<body> 
    <div class="login-box"> 
        <div class="text-center"> 
            <div class="mb-3"> 
                <!--avatar-->
                <img src="layout/img/logo.png" alt="Logo" width="80">
            </div> 
            <h4>Log in</h4> 
            <p>Don't have an account? <a href="register.php">Sign up</a></p> 
        </div>
        
        <div class="social-login"> 
            <!-- <button type="button" class="btn btn-outline-primary w-100 mb-3 rounded-pill">  
                <i class="bi bi-facebook me-2"></i> Log in with Facebook 
            </button>  -->
            <button type="button" class="btn btn-outline-danger w-100 mb-3 rounded-pill">  
                <i class="bi bi-google me-2"></i> Log in with Google 
            </button> 
        </div> 
        <div class="d-flex align-items-center my-2"> 
            <hr class="flex-grow-1"> 
            <span class="mx-2">OR</span> 
            <hr class="flex-grow-1"> 
        </div> 
         
        <!-- Form đăng nhập PHP --> 
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"> 
            <div class="mb-3"> 
                <label class="form-label">Username</label> 
                <input type="text" name="user" class="form-control" placeholder="Enter your username" required> 
            </div> 
            <div class="mb-3"> 
                <label class="form-label">Password</label> 
                <input type="password" name="pass" class="form-control" placeholder="Enter your password" required> 
            </div> 
            <!-- <div class="d-flex justify-content-between mb-3"> 
                <div> 
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label> 
                </div> 
                <a href="reset_password.php">Forget your password?</a> 
            </div>  -->
            <button type="submit" name="dangnhap" value="1" class="btn btn-primary w-100">Log in</button> 

            <?php if (!empty($error)): ?>
                <div class="error-text">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
        </form> 
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
</body> 
</html>
<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
    $userinfo = get_user($id);
    extract($userinfo);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .btn-facebook:hover {
            background-color: #3b5998;
            color: white;
        }
        .btn-google:hover {
            background-color: #db4437;
            color: white;
        }
        .card-img-left {
            object-fit: cover;
            height: 100%;
        }
        .info-label {
            font-weight: 500;
            color: #555;
        }
    </style>
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-lg overflow-hidden" style="max-width: 1000px; max-height: 800px; width: 100%;">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="layout/img/signup.png" class="img-fluid card-img-left" alt="A close-up of a hand with rings and a blurred background">
            </div>
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <h2 class="fw-bold mb-4 text-center">Thông tin tài khoản</h2>
                
                <div class="mb-3">
                    <label class="info-label">Tên đăng nhập</label>
                    <div class="form-control-plaintext"><?= htmlspecialchars($username) ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="info-label">Email</label>
                    <div class="form-control-plaintext"><?= htmlspecialchars($email) ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="info-label">Địa chỉ</label>
                    <div class="form-control-plaintext"><?= htmlspecialchars($address) ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="info-label">Điện thoại</label>
                    <div class="form-control-plaintext"><?= htmlspecialchars($phone) ?></div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="index.php?pg=updateinfo" class="btn btn-primary mb-2 w-100">
                        <i class="fas fa-user-edit me-1"></i> Cập nhật thông tin
                    </a>
                    <a href="index.php?pg=changepassword_form" class="btn btn-warning mb-2 w-100">
                        <i class="fas fa-key me-1"></i> Đổi mật khẩu
                    </a>
                    <a href="index.php" class="btn btn-outline-secondary mb-2 w-100">
                        <i class="fas fa-home me-1"></i> Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
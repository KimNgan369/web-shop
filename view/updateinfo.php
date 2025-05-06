<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin</title>
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
    </style>
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-lg rounded-lg overflow-hidden" style="max-width: 1000px; max-height: 800px; width: 100%;">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="layout/img/signup.png" class="img-fluid card-img-left" alt="A close-up of a hand with rings and a blurred background">
            </div>
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center text-center">
                <h2 class="fw-bold mb-2">Cập nhật thông tin</h2>
                
                <!-- Hiển thị thông báo lỗi nếu có -->
                
                <form method="POST" action="index.php?pg=updateuser">
                    <div class="form-floating mb-3 text-start">
                        <input type="text" class="form-control rounded-pill" id="username" value="<?=$username?>" name="username" placeholder="Your username">
                        <label for="username">Tên đăng nhập</label>
                    </div>

                    <div class="form-floating mb-4 text-start">
                        <input type="email" class="form-control rounded-pill" id="email"  value="<?=$email?>"  name="email" placeholder="Your email">
                        <label for="email">Email</label>
                    </div>

                    <div class="form-floating mb-4 text-start">
                        <input type="text" class="form-control rounded-pill" id="address" value="<?=$address?>" name="address" placeholder="Your address">
                        <label for="address">Địa chỉ</label>
                    </div>

                    <div class="form-floating mb-4 text-start">
                        <input type="phone" class="form-control rounded-pill" id="phone" value="<?=$phone?>" name="phone" placeholder="Your phone">
                        <label for="phone">Điện thoại</label>
                    </div>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                    <input type="submit" name="update" class="btn btn-secondary w-100 mb-3 rounded-pill" value="Cập nhật">

                    <div class="text-center mt-4">
                        <a href="index.php?pg=myacc" class="btn btn-outline-warning border-dark text-black text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
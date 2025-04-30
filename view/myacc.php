<?php
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

                
                <div class="form-floating mb-3 text-start">
                    <input type="text" class="form-control rounded-pill" id="username" name="username" placeholder="Your username">
                    <label for="username">Tên đăng nhập</label>
                </div>

                <div class="form-floating mb-3 text-start">
                    <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Your password">
                    <label for="password">Họ tên</label>
                </div>

                <div class="form-floating mb-3 text-start">
                    <input type="password" class="form-control rounded-pill" id="repassword" name="repassword" placeholder="Re-enter your password">
                    <label for="repassword">Email</label>
                </div>

                <div class="form-floating mb-4 text-start">
                    <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Your email">
                    <label for="email">Số điện thoại</label>
                </div>

                <div class="form-floating mb-4 text-start">
                    <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Your email">
                    <label for="email">Địa chỉ</label>
                </div>

                <input type="submit" name="update" class="btn btn-secondary w-100 mb-3 rounded-pill" value="Cập nhật">
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
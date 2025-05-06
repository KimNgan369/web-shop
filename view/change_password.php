<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
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
                <h2 class="fw-bold mb-2">Đổi mật khẩu</h2>
                
                <!-- Hiển thị thông báo lỗi nếu có -->
                <?php if(isset($_SESSION['password_error'])): ?>
                    <div class="alert alert-danger">
                        <?= $_SESSION['password_error'] ?>
                    </div>
                    <?php unset($_SESSION['password_error']); ?>
                <?php endif; ?>
                
                <form method="POST" action="index.php?pg=changepassword">
                    <div class="form-floating mb-3 text-start">
                        <input type="password" class="form-control rounded-pill" id="current_password" name="current_password" placeholder="Mật khẩu hiện tại" required>
                        <label for="current_password">Mật khẩu hiện tại</label>
                    </div>

                    <div class="form-floating mb-3 text-start">
                        <input type="password" class="form-control rounded-pill" id="new_password" name="new_password" placeholder="Mật khẩu mới" required>
                        <label for="new_password">Mật khẩu mới</label>
                    </div>

                    <div class="form-floating mb-4 text-start">
                        <input type="password" class="form-control rounded-pill" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu mới" required>
                        <label for="confirm_password">Xác nhận mật khẩu mới</label>
                    </div>

                    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                    <input type="submit" name="change_password" class="btn btn-secondary w-100 mb-3 rounded-pill" value="Xác nhận">

                    <div class="text-center mt-4">
                        <button class="btn btn-outline-warning border-dark">
                            <a href="index.php?pg=myacc" class="text-black text-decoration-none">Quay lại</a>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$username = isset($user['username']) ? htmlspecialchars($user['username']) : '';
$full_name = isset($user['full_name']) ? htmlspecialchars($user['full_name']) : '';
$email = isset($user['email']) ? htmlspecialchars($user['email']) : '';
$phone = isset($user['phone']) ? htmlspecialchars($user['phone']) : '';
$address = isset($user['address']) ? htmlspecialchars($user['address']) : '';
$role = isset($user['role']) ? $user['role'] : 'user';
$is_vip = isset($user['is_vip']) ? $user['is_vip'] : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <div class="main-content">
        <header class="main-header">
            <h1 id="section-title">Cập nhật người dùng</h1>
            <img class="account-icon" src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Account Icon"/>
        </header>
        <div class="add-product">
            <form class="addUser" action="index.php?act=updateuser" method="POST">
                <input type="hidden" name="id" value="<?php echo isset($user['id']) ? $user['id'] : ''; ?>">
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>" placeholder="Nhập tên đăng nhập" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu mới (để trống nếu không đổi):</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu mới">
                </div>
                <div class="form-group">
                    <label for="full_name">Họ và tên:</label>
                    <input type="text" class="form-control" name="full_name" id="full_name" value="<?php echo $full_name; ?>" placeholder="Nhập họ và tên">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $email; ?>" placeholder="Nhập email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $phone; ?>" placeholder="Nhập số điện thoại">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <textarea class="form-control" name="address" id="address" placeholder="Nhập địa chỉ"><?php echo $address; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="role">Vai trò:</label>
                    <select class="form-select" name="role" id="role" required>
                        <option value="user" <?php echo ($role == 'user') ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo ($role == 'admin') ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_vip">Trạng thái:</label>
                    <select class="form-select" name="is_vip" id="is_vip" required>
                        <option value="0" <?php echo ($is_vip == 0) ? 'selected' : ''; ?>>Inactive</option>
                        <option value="1" <?php echo ($is_vip == 1) ? 'selected' : ''; ?>>Active</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name="updateuser" class="btn">Cập nhật người dùng</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        CKEDITOR.replace('address');
    </script>
</body>
</html>
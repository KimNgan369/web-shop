<?php
// Hàm làm sạch HTML để tránh XSS (thay thế cho HTML Purifier nếu bạn không cài thư viện)
function sanitize_html($html) {
    // Danh sách các thẻ HTML được phép
    $allowed_tags = '<p><b><i><u><strong><em><br><ul><ol><li><a>';
    return strip_tags($html, $allowed_tags);
}

$html_list_user = '';
foreach ($userlist as $user) {
    extract($user);
    // Đảm bảo tất cả các trường có giá trị mặc định nếu null
    $username = isset($username) ? htmlspecialchars($username) : 'N/A';
    $full_name = isset($full_name) ? htmlspecialchars($full_name) : 'N/A';
    $email = isset($email) ? htmlspecialchars($email) : 'N/A';
    $phone = isset($phone) ? htmlspecialchars($phone) : 'N/A';
    // Hiển thị định dạng HTML cho address sau khi làm sạch
    $address = isset($address) ? sanitize_html($address) : 'N/A';
    $total_spent = isset($total_spent) ? number_format($total_spent, 2) : '0.00';
    $role = isset($role) ? htmlspecialchars($role) : 'N/A';
    $created_at = isset($created_at) ? htmlspecialchars($created_at) : 'N/A';
    $updated_at = isset($updated_at) ? htmlspecialchars($updated_at) : 'N/A';
    $id = isset($id) ? htmlspecialchars($id) : '';

    $html_list_user .= '<tr>
                          <td>' . $id . '</td>
                          <td>' . $username . '</td>
                          <td>' . $full_name . '</td>
                          <td>' . $email . '</td>
                          <td>' . $phone . '</td>
                          <td>' . $address . '</td>
                          <td>' . $total_spent . '</td>
                          <td>' . $role . '</td>
                          <td>' . $created_at . '</td>
                          <td>' . $updated_at . '</td>
                          <td>
                            <a href="index.php?act=updateuser&id=' . $id . '" class="edit-btn">Sửa</a>
                            <a href="index.php?act=deluser&id=' . $id . '" class="delete-btn" onclick="return confirm(\'Bạn có chắc muốn xóa người dùng này?\')">Xóa</a>
                          </td>
                        </tr>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quản lý người dùng</title>
    <style>
        .main-content {
            padding: 20px;
        }
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .main-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .account-icon {
            width: 30px;
            height: 30px;
        }
        .user-management {
            margin-top: 20px;
        }
        .button-add {
            display: inline-block;
            padding: 10px 15px;
            background-color: #f5d038;
            color: #333;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .button-add:hover {
            background-color: #e6c233;
        }
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
        .user-table th,
        .user-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .user-table th {
            background-color: #f5d038;
            color: #333;
        }
        .user-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .edit-btn,
        .delete-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: #333;
        }
        .edit-btn {
            background-color: #f5d038;
            margin-right: 5px;
        }
        .edit-btn:hover {
            background-color: #e6c233;
        }
        .delete-btn {
            background-color: #f5d038;
        }
        .delete-btn:hover {
            background-color: #e6c233;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <header class="main-header">
            <h1 id="section-title">Quản lý người dùng</h1>
            <img class="account-icon" src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Account Icon"/>
        </header>
        <div class="user-management">
            <a href="index.php?act=useradd" class="button-add">Thêm người dùng mới</a>
            <?php if (empty($userlist)): ?>
                <p>Không có người dùng nào để hiển thị.</p>
            <?php else: ?>
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Tổng chi tiêu</th>
                            <th>Vai trò</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $html_list_user; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
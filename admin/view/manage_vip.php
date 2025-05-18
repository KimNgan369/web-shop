<?php
// Lấy danh sách người dùng VIP từ database
$viplist = get_vip_users();
$html_vip_list = '';
foreach ($viplist as $vip) {
    $id = isset($vip['id']) ? htmlspecialchars($vip['id']) : 'N/A';
    $full_name = isset($vip['full_name']) ? htmlspecialchars($vip['full_name']) : 'N/A';
    $email = isset($vip['email']) ? htmlspecialchars($vip['email']) : 'N/A';
    $phone = isset($vip['phone']) ? htmlspecialchars($vip['phone']) : 'N/A';
    $total_spent = isset($vip['total_spent']) ? number_format(floatval($vip['total_spent']), 2) : '0.00';

    $html_vip_list .= '<tr>
                          <td>' . $id . '</td>
                          <td>' . $full_name . '</td>
                          <td>' . $email . '</td>
                          <td>' . $phone . '</td>
                          <td>$' . $total_spent . '</td>
                          <td class="manageorder-action">
                            <a href="index.php?act=updatevip&id=' . $id . '" class="edit-btn">Sửa</a>
                            <a href="index.php?act=delvip&id=' . $id . '" class="delete-btn" onclick="return confirm(\'Bạn có chắc muốn xóa VIP này?\')">Xóa</a>
                          </td>
                        </tr>';
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="main-content">
        <header class="main-header">
            <h1 id="section-title">Quản lý VIP</h1>
            <img class="account-icon" src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Account Icon"/>
        </header>
        <div class="product-management">
            <a href="index.php?act=vipadd" class="button-add">Thêm VIP mới</a>
            <?php if (empty($viplist)): ?>
                <p>Không có VIP nào để hiển thị.</p>
            <?php else: ?>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên VIP</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Tổng chi tiêu</th>
                            <th class="manageorder-action">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $html_vip_list; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
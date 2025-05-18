<?php
include "../dao/orders.php";
$html_orderlist = '';
foreach ($orderlist as $order) {
    $payment_method = $order['payment_method'] === 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản';
    // Kết hợp địa chỉ
    $address = htmlspecialchars($order['customer_address'] . ', ' . $order['district'] . ', ' . $order['province']);
    // Danh sách sản phẩm
    $items_list = '';
if (!empty($order['items'])) {
    foreach ($order['items'] as $item) {
        $items_list .= '<div class="product-item d-flex align-items-center mb-2">';
        if (!empty($item['image'])) {
            $items_list .= '<img src="../admin/images/' . htmlspecialchars($item['image']) . '" width="40" class="me-2">';
        }
        $items_list .= '<div>';
        $items_list .= '<div>' . htmlspecialchars($item['product_name']) . '</div>';
        $items_list .= '<small class="text-muted">' . $item['quantity'] . ' x $' . number_format($item['price'], 2) . '</small>';
        $items_list .= '</div>';
        $items_list .= '</div>';
    }
} else {
    $items_list = '<div class="text-danger">Chưa có sản phẩm</div>';
}
    $notes = $order['notes'] ? htmlspecialchars($order['notes']) : 'Không có';
    
    $html_orderlist .= '<tr>
                          <td>' . htmlspecialchars($order['order_code'] ?? 'N/A') . '</td>
                          <td>' . htmlspecialchars($order['order_id']) . '</td>
                          <td>' . htmlspecialchars($order['customer_name']) . '</td>
                          <td>' . htmlspecialchars($order['customer_phone']) . '</td>
                          <td>' . $address . '</td>
                          <td>$' . number_format($order['total_amount'], 2) . '</td>
                          <td>' . htmlspecialchars($payment_method) . '</td>
                          <td>' . htmlspecialchars($order['status']) . '</td>
                          <td>' . $notes . '</td>
                          <td>' . htmlspecialchars($order['order_date']) . '</td>
                          <td>' . $items_list . '</td>
                          <td class="manageorder-action">
                            <a href="index.php?act=updateorder&id=' . $order['order_id'] . '" class="edit-btn">Sửa</a>
                            <a href="index.php?act=delorder&id=' . $order['order_id'] . '" class="delete-btn" onclick="return confirm(\'Bạn có chắc muốn xóa đơn hàng này?\')">Xóa</a>
                          </td>
                        </tr>';
}
?>

<div class="main-content">
    <!-- Header hiển thị tên mục theo menu -->
    <header class="main-header">
        <h1 id="section-title">Quản lý đơn hàng</h1>
        <!-- Icon tài khoản -->
        <img 
            class="account-icon" 
            src="https://cdn-icons-png.flaticon.com/512/747/747376.png" 
            alt="Account Icon"
        />
    </header>
    <div class="order-management">
        <table class="product-table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Tổng tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Trạng thái</th>
                    <th>Ghi chú</th>
                    <th>Ngày đặt</th>
                    <th>Sản phẩm</th>
                    <th class="manageorder-action">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orderlist)): ?>
                    <?= $html_orderlist; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="12" class="text-center">Không có đơn hàng nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
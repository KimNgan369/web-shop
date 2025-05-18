<?php
require_once '../dao/pdo.php';
require_once '../dao/orders.php';

// Load order data if id is provided
$order = [];
$order_id = isset($_GET['id']) ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) : (isset($_POST['order_id']) ? filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT) : null);

if ($order_id) {
    $sql = "SELECT order_id, customer_name, customer_phone, customer_address, 
                   COALESCE(district, '') as district, 
                   COALESCE(province, '') as province, 
                   COALESCE(notes, '') as notes, 
                   payment_method, status 
            FROM orders 
            WHERE order_id = ?";
    $order = pdo_query_one($sql, $order_id);
    if (!$order) {
        $error_message = "Đơn hàng không tồn tại.";
        error_log("Order not found for order_id=$order_id at " . date('Y-m-d H:i:s'));
    } else {
        error_log("Loaded order_id=$order_id: " . print_r($order, true));
    }
} else {
    $error_message = "Không có ID đơn hàng được cung cấp.";
    error_log("No order_id provided at " . date('Y-m-d H:i:s'));
}

// Initialize variables
$order_id = isset($order['order_id']) ? $order['order_id'] : '';
$customer_name = isset($order['customer_name']) ? $order['customer_name'] : '';
$customer_phone = isset($order['customer_phone']) ? $order['customer_phone'] : '';
$customer_address = isset($order['customer_address']) ? $order['customer_address'] : '';
$district = isset($order['district']) ? $order['district'] : '';
$province = isset($order['province']) ? $order['province'] : '';
$notes = isset($order['notes']) ? $order['notes'] : '';
$payment_method = isset($order['payment_method']) ? $order['payment_method'] : '';
$status = isset($order['status']) ? $order['status'] : '';

// Load provinces and districts
$provinces = [];
$districts = [];
try {
    // Try API
    $province_data = @file_get_contents('https://provinces.open-api.vn/api/p/');
    if ($province_data !== false) {
        $provinces = json_decode($province_data, true);
    } else {
        throw new Exception('API failed');
    }
    $district_data = @file_get_contents('https://provinces.open-api.vn/api/d/');
    if ($district_data !== false) {
        $districts = json_decode($district_data, true);
    } else {
        throw new Exception('API failed');
    }
} catch (Exception $e) {
    // Fallback to JSON files
    error_log("API error: " . $e->getMessage() . " at " . date('Y-m-d H:i:s'));
    $provinces = json_decode(file_get_contents('data/provinces.json'), true);
    $districts = json_decode(file_get_contents('data/districts.json'), true);
}

// Create HTML for provinces
$html_provinces = '<option value="">Chọn tỉnh/thành phố</option>';
foreach ($provinces as $p) {
    $selected = ($p['name'] == $province) ? 'selected' : '';
    $html_provinces .= '<option value="' . htmlspecialchars($p['name']) . '" ' . $selected . ' data-code="' . $p['code'] . '">' . htmlspecialchars($p['name']) . '</option>';
}

// Create HTML for districts (filtered by selected province)
$html_districts = '<option value="">Chọn quận/huyện</option>';
$selected_province_code = null;
foreach ($provinces as $p) {
    if ($p['name'] == $province) {
        $selected_province_code = $p['code'];
        break;
    }
}
foreach ($districts as $d) {
    if ($selected_province_code && $d['province_code'] == $selected_province_code) {
        $selected = ($d['name'] == $district) ? 'selected' : '';
        $html_districts .= '<option value="' . htmlspecialchars($d['name']) . '" ' . $selected . '>' . htmlspecialchars($d['name']) . '</option>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <div class="main-content">
        <header class="main-header">
            <h1 id="section-title">Cập nhật đơn hàng</h1>
            <img class="account-icon" src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Account Icon"/>
        </header>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <div class="add-product">
            <form class="addOrder" action="index.php?act=updateorder" method="POST">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
                
                <div class="form-group">
                    <label for="customer_name">Tên khách hàng:</label>
                    <input type="text" class="form-control" name="customer_name" value="<?= htmlspecialchars($customer_name) ?>" id="customer_name" placeholder="Nhập tên khách hàng" required>
                </div>
                
                <div class="form-group">
                    <label for="customer_phone">Số điện thoại:</label>
                    <input type="text" class="form-control" name="customer_phone" value="<?= htmlspecialchars($customer_phone) ?>" id="customer_phone" placeholder="Nhập số điện thoại" required>
                </div>
                
                <div class="form-group">
                    <label for="customer_address">Địa chỉ:</label>
                    <input type="text" class="form-control" name="customer_address" value="<?= htmlspecialchars($customer_address) ?>" id="customer_address" placeholder="Nhập địa chỉ" required>
                </div>
                
                <div class="form-group">
                    <label for="province">Tỉnh/Thành phố:</label>
                    <select class="form-select" name="province" id="province" onchange="updateDistricts()">
                        <?= $html_provinces ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="district">Quận/Huyện:</label>
                    <select class="form-select" name="district" id="district">
                        <?= $html_districts ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="notes">Ghi chú:</label>
                    <textarea class="form-control" name="notes" id="notes" placeholder="Nhập ghi chú"><?= htmlspecialchars($notes) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="payment_method">Phương thức thanh toán:</label>
                    <select class="form-select" name="payment_method" id="payment_method" required>
                        <option value="cod" <?= $payment_method == 'cod' ? 'selected' : '' ?>>Thanh toán khi nhận hàng</option>
                        <option value="bank" <?= $payment_method == 'bank' ? 'selected' : '' ?>>Chuyển khoản</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <select class="form-select" name="status" id="status" required>
                        <option value="pending" <?= $status == 'pending' ? 'selected' : '' ?>>Đang chờ</option>
                        <option value="confirmed" <?= $status == 'confirmed' ? 'selected' : '' ?>>Đã xác nhận</option>
                        <option value="shipped" <?= $status == 'shipped' ? 'selected' : '' ?>>Đang giao</option>
                        <option value="delivered" <?= $status == 'delivered' ? 'selected' : '' ?>>Đã giao</option>
                        <option value="cancelled" <?= $status == 'cancelled' ? 'selected' : '' ?>>Đã hủy</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" name="updateorder" class="btn">Cập nhật đơn hàng</button>
                    <a href="index.php?act=manage_orders" class="btn">Quay lại danh sách</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="layout/js/admin.js"></script>
    <script>
        CKEDITOR.replace('notes');

        async function updateDistricts() {
            const provinceSelect = document.getElementById('province');
            const districtSelect = document.getElementById('district');
            const selectedProvince = provinceSelect.value;
            const provinceCode = provinceSelect.options[provinceSelect.selectedIndex]?.dataset.code;

            districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';

            if (!provinceCode) return;

            try {
                const response = await fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`);
                if (!response.ok) throw new Error('API failed');
                const data = await response.json();
                const districts = data.districts || [];

                districts.forEach(d => {
                    const option = document.createElement('option');
                    option.value = d.name;
                    option.text = d.name;
                    if (d.name === '<?php echo addslashes($district); ?>') {
                        option.selected = true;
                    }
                    districtSelect.appendChild(option);
                });
            } catch (error) {
                console.error('API error:', error);
                // Fallback to JSON
                const districts = <?php echo json_encode($districts); ?>;
                districts.forEach(d => {
                    if (d.province_code == provinceCode) {
                        const option = document.createElement('option');
                        option.value = d.name;
                        option.text = d.name;
                        if (d.name === '<?php echo addslashes($district); ?>') {
                            option.selected = true;
                        }
                        districtSelect.appendChild(option);
                    }
                });
            }
        }
    </script>
</body>
</html>
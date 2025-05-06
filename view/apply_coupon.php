<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Fix CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Kiểm tra phương thức
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

// Kiểm tra kết nối database
try {
    // Đảm bảo đường dẫn đúng tới pdo.php
    $pdoPath = __DIR__ . '/../dao/pdo.php';
    if (!file_exists($pdoPath)) {
        throw new Exception('Database connection file not found');
    }
    
    include $pdoPath;

    $pdo = pdo_get_connection();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}

// Lấy dữ liệu từ POST (hỗ trợ cả JSON và form-data)
$input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$couponCode = trim($input['coupon_code'] ?? '');
$subtotal = (float)($input['subtotal'] ?? 0);

// Validate dữ liệu đầu vào
if (empty($couponCode)) {
    echo json_encode(['success' => false, 'message' => '"Please enter the discount code."']);
    exit;
}

if ($subtotal <= 0) {
    echo json_encode(['success' => false, 'message' => 'Order value is invalid']);
    exit;
}

try {
    // 1. Kiểm tra coupon trong database
    $stmt = $pdo->prepare("
        SELECT * FROM coupons 
        WHERE code = :code 
        AND is_active = 1 
        AND (start_date <= NOW() OR start_date IS NULL) 
        AND (end_date >= NOW() OR end_date IS NULL)
        AND (usage_limit IS NULL OR used_count < usage_limit)
    ");
    $stmt->execute([':code' => $couponCode]);
    $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$coupon) {
        echo json_encode(['success' => false, 'message' => 'Invalid promo code: expired or usage limit reached']);
        exit;
    }

    // 2. Kiểm tra điều kiện đơn hàng tối thiểu
    $minOrder = (float)$coupon['min_order'];
    if ($subtotal < $minOrder) {
        echo json_encode([
            'success' => false,
            'message' => sprintf('Minimum order requirement of %s to apply this discount code', number_format($minOrder, 2))
        ]);
        exit;
    }

    // 3. Tính toán giảm giá (xử lý cả fixed và percent)
    $discount = 0;
    if ($coupon['discount_type'] === 'percent') {
        $discount = $subtotal * ($coupon['discount_value'] / 100);
    } else {
        $discount = min($coupon['discount_value'], $subtotal);
    }

    // 4. Cập nhật số lần sử dụng coupon (nếu có giới hạn)
    if ($coupon['usage_limit'] !== null) {
        $updateStmt = $pdo->prepare("
            UPDATE coupons 
            SET used_count = used_count + 1 
            WHERE id = :id AND (used_count < usage_limit OR usage_limit IS NULL)
        ");
        $updateStmt->execute([':id' => $coupon['id']]);
    }

    // 5. Lưu vào session
    if (isset($_SESSION['applied_coupon'])) {
        unset($_SESSION['applied_coupon']);
    }
    $_SESSION['applied_coupon'] = [
        'id' => $coupon['id'],
        'code' => $coupon['code'],
        'discount' => $discount,
        'type' => $coupon['discount_type'],
        'value' => $coupon['discount_value'],
        'min_order' => $coupon['min_order']
    ];

    // 6. Trả về kết quả
    echo json_encode([
        'success' => true,
        'discount' => $discount,
        'discount_formatted' => number_format($discount, 2),
        'message' => 'The discount code has been successfully applied!',
        'coupon_info' => [
            'code' => $coupon['code'],
            'type' => $coupon['discount_type'],
            'value' => $coupon['discount_value'],
            'min_order' => $coupon['min_order']
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi database: ' . $e->getMessage(),
        'error_details' => $e->getTraceAsString()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi hệ thống: ' . $e->getMessage()
    ]);
}
?>













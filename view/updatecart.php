<?php
session_start();
header('Content-Type: application/json'); // Thêm header này

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Xử lý xóa nhiều sản phẩm
        if (isset($_POST['ids'])) {
            $ids = json_decode($_POST['ids']);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Dữ liệu JSON không hợp lệ');
            }
            
            foreach ($ids as $id) {
                $productId = (int)$id;
                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
            echo json_encode(['success' => true, 'message' => 'Xóa thành công']);
            exit;
        }

        // Xử lý thay đổi số lượng
        if (isset($_POST['id']) && isset($_POST['change'])) {
            $productId = (int)$_POST['id'];
            $change = (int)$_POST['change'];

            if (!isset($_SESSION['cart'][$productId])) {
                throw new Exception('Sản phẩm không tồn tại trong giỏ hàng');
            }

            $_SESSION['cart'][$productId]['quantity'] += $change;

            if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                unset($_SESSION['cart'][$productId]);
            }

            echo json_encode([
                'success' => true,
                'newQuantity' => $_SESSION['cart'][$productId]['quantity'] ?? 0
            ]);
            exit;
        }

        throw new Exception('Yêu cầu không hợp lệ');
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage()
    ]);
    exit;
}
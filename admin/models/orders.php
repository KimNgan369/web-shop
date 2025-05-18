<?php
require_once 'pdo.php'; // Nạp pdo.php để sử dụng pdo_get_connection()

function save_order_to_database($customer_info, $cart_items, $total, $payment_method) {
    // Khởi tạo kết nối PDO
    $pdo = pdo_get_connection();
    
    try {
        // Bắt đầu transaction
        $pdo->beginTransaction();
        
        // 1. Lưu thông tin chính đơn hàng
        $stmt = $pdo->prepare("INSERT INTO orders (
            customer_name, 
            customer_email, 
            customer_phone, 
            customer_address,
            province,
            district,
            notes,
            total_amount,
            payment_method,
            order_date,
            status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pending')");
        
        $full_name = $customer_info['first_name'] . ' ' . $customer_info['last_name'];
        $stmt->execute([
            $full_name,
            $customer_info['email'],
            $customer_info['phone'],
            $customer_info['address'],
            $customer_info['province'],
            $customer_info['district'],
            $customer_info['notes'],
            $total,
            $payment_method
        ]);
        
        $order_id = $pdo->lastInsertId();
        
        // 2. Lưu các sản phẩm trong đơn hàng
        $stmt = $pdo->prepare("INSERT INTO order_items (
            order_id, 
            product_id, 
            product_name, 
            price, 
            quantity, 
            subtotal
        ) VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($cart_items as $item) {
            $subtotal = $item['price'] * $item['quantity'];
            $stmt->execute([
                $order_id,
                $item['id'],
                $item['name'],
                $item['price'],
                $item['quantity'],
                $subtotal
            ]);
        }
        
        // Commit transaction
        $pdo->commit();
        
        return $order_id;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Order save failed: " . $e->getMessage());
        return false;
    }
}

function get_order_from_database($order_id) {
    // Khởi tạo kết nối PDO
    $pdo = pdo_get_connection();
    
    try {
        // Lấy thông tin đơn hàng chính
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) return false;
        
        // Lấy các sản phẩm trong đơn hàng
        $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Format lại giống cấu trúc cũ
        $order['cart'] = [];
        foreach ($items as $item) {
            $order['cart'][$item['product_id']] = [
                'id' => $item['product_id'],
                'name' => $item['product_name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image' => '' // Cần bổ sung nếu muốn hiển thị ảnh
            ];
        }
        
        return $order;
    } catch (PDOException $e) {
        error_log("Get order failed: " . $e->getMessage());
        return false;
    }
}

function get_all_orders() {
    // Khởi tạo kết nối PDO
    $pdo = pdo_get_connection();
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders ORDER BY order_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Get all orders failed: " . $e->getMessage());
        return [];
    }
}

function delete_order($order_id) {
    // Khởi tạo kết nối PDO
    $pdo = pdo_get_connection();
    
    try {
        $pdo->beginTransaction();
        
        // Xóa các mục trong order_items
        $stmt = $pdo->prepare("DELETE FROM order_items WHERE order_id = ?");
        $stmt->execute([$order_id]);
        
        // Xóa đơn hàng
        $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);
        
        $pdo->commit();
        return true;
    } catch (PDOException $e) {
        $pdo->rollBack();
        error_log("Delete order failed: " . $e->getMessage());
        return false;
    }
}
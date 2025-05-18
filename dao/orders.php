<?php
require_once 'pdo.php';

if (!function_exists('save_order_to_database')) {
    function save_order_to_database($customer_info, $cart_items, $total, $payment_method, $order_code, $user_id = null) {
        $pdo = pdo_get_connection();
        
        try {
            // Bắt đầu giao dịch
            $pdo->beginTransaction();
            
            // 1. Lưu thông tin đơn hàng vào bảng orders
            $sql = "INSERT INTO orders (
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
                status,
                order_code,
                user_id
            ) VALUES (:name, :email, :phone, :address, :province, :district, 
                     :notes, :total, :payment_method, NOW(), 'pending', :order_code, :user_id)";
            
            $stmt = $pdo->prepare($sql);
            
            // Tạo tên đầy đủ từ first_name và last_name
            $full_name = trim($customer_info['first_name'] . ' ' . $customer_info['last_name']);
            
            $stmt->execute([
                ':name' => $full_name,
                ':email' => $customer_info['email'],
                ':phone' => $customer_info['phone'],
                ':address' => $customer_info['address'],
                ':province' => $customer_info['province'],
                ':district' => $customer_info['district'],
                ':notes' => $customer_info['notes'] ?? '',
                ':total' => $total,
                ':payment_method' => $payment_method,
                ':order_code' => $order_code,
                ':user_id' => $user_id // Lưu user_id, có thể là NULL nếu không có
            ]);
            
            // Lấy ID của đơn hàng vừa tạo
            $order_id = $pdo->lastInsertId();
            
            // 2. Lưu từng sản phẩm vào bảng order_items
            foreach ($cart_items as $item) {
                $sql = "INSERT INTO order_items (
                    order_id, 
                    product_id, 
                    product_name, 
                    price, 
                    quantity, 
                    subtotal
                ) VALUES (
                    :order_id, 
                    :product_id, 
                    :product_name, 
                    :price, 
                    :quantity, 
                    :subtotal
                )";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':order_id' => $order_id,
                    ':product_id' => $item['id'],
                    ':product_name' => $item['name'],
                    ':price' => $item['price'],
                    ':quantity' => $item['quantity'],
                    ':subtotal' => $item['price'] * $item['quantity']
                ]);
            }
            
            // Hoàn tất giao dịch
            $pdo->commit();
            
            // Ghi log thành công
            error_log("Đơn hàng được lưu thành công. ID: $order_id, Mã: $order_code, Số sản phẩm: " . count($cart_items));
            return $order_id;
            
        } catch (PDOException $e) {
            // Hủy giao dịch nếu có lỗi
            $pdo->rollBack();
            // Ghi log lỗi chi tiết
            error_log("Lưu đơn hàng thất bại: " . $e->getMessage());
            error_log("Lỗi SQL: " . $e->getTraceAsString());
            error_log("Danh sách sản phẩm: " . print_r($cart_items, true));
            
            return false;
        }
    }
}

if (!function_exists('get_order_from_database')) {
    function get_order_from_database($order_id) {
    $pdo = pdo_get_connection();
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $order_id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$order) {
            error_log("Order not found with ID: $order_id");
            return false;
        }
        
        return $order;
        
    } catch (PDOException $e) {
        error_log("Get order failed: " . $e->getMessage());
        return false;
    }
}
}
if (!function_exists('get_all_orders')) {
    function get_all_orders() {
    $pdo = pdo_get_connection();
    try {
        // Lấy danh sách đơn hàng
        $stmt = $pdo->query("SELECT * FROM orders ORDER BY order_date DESC");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Lấy sản phẩm cho từng đơn hàng
        foreach ($orders as &$order) {
            $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
            $stmt->execute([$order['order_id']]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $orders;
    } catch (PDOException $e) {
        error_log("Get all orders failed: " . $e->getMessage());
        return [];
    }
}
}

if (!function_exists('delete_order')) {
function delete_order($order_id) {
    $pdo = pdo_get_connection();
    
    try {
        $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = :order_id");
        $stmt->execute([':order_id' => $order_id]);
        
        return $stmt->rowCount() > 0;
        
    } catch (PDOException $e) {
        error_log("Delete order failed: " . $e->getMessage());
        return false;
    }
}
}


// Trong orders.php

if (!function_exists('update_user_spent_and_vip')) {
    function update_user_spent_and_vip($user_id) {
    // Get sum of total_amount for delivered orders
    $sql = "SELECT SUM(total_amount) as total_spent 
            FROM orders 
            WHERE user_id = ? AND status = 'delivered'";
    $total_spent = pdo_query_value($sql, $user_id);
    
    // If no delivered orders, set total_spent to 0
    $total_spent = $total_spent ?: 0;
    
    // Update total_spent and is_vip
    $is_vip = ($total_spent >= 1000) ? 1 : 0;
    $sql = "UPDATE users 
            SET total_spent = ?, is_vip = ? 
            WHERE id = ?";
    pdo_execute($sql, $total_spent, $is_vip, $user_id);
    
    // Log for debugging
    error_log("Updated user $user_id: total_spent=$total_spent, is_vip=$is_vip at " . date('Y-m-d H:i:s'));
}

// Other order-related functions (e.g., save_order_to_database) go here

}



// function update_order($order_id, $customer_name, $customer_phone, $customer_address, $district, $province, $notes, $payment_method, $status) {
//     $pdo = pdo_get_connection();
    
//     try {
//         $sql = "UPDATE orders SET 
//                 customer_name = :name,
//                 customer_phone = :phone,
//                 customer_address = :address,
//                 district = :district,
//                 province = :province,
//                 notes = :notes,
//                 payment_method = :payment_method,
//                 status = :status,
//                 updated_at = NOW()
//                 WHERE order_id = :order_id";
        
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute([
//             ':name' => $customer_name,
//             ':phone' => $customer_phone,
//             ':address' => $customer_address,
//             ':district' => $district,
//             ':province' => $province,
//             ':notes' => $notes,
//             ':payment_method' => $payment_method,
//             ':status' => $status,
//             ':order_id' => $order_id
//         ]);
        
//         return $stmt->rowCount() > 0;
        
//     } catch (PDOException $e) {
//         error_log("Update order failed: " . $e->getMessage());
//         return false;
//     }
// }
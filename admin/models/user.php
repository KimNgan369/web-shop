<?php 
function checkuser($user, $pass){
    $conn = pdo_get_connection();
    // Sử dụng prepared statement đúng cách để ngăn chặn SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$user, $pass]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Kiểm tra xem có kết quả trả về không
    if($result) {
        return $result['role'];
    } else {
        return 0; // Trả về 0 nếu không tìm thấy người dùng
    }
}
?>
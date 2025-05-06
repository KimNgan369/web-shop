<?php
session_start();

if (!isset($_SESSION['order_info'])) {
    header("Location: ../index.php");
    exit();
}

$order = $_SESSION['order_info'];
$phone = $order['customer']['phone'];
$total = $order['total'];

// Thông tin tài khoản chuyển khoản
$bank_code = "VCB";
$account_number = "0123456789";
$account_name = "CONG TY ABC";
$transfer_content = $phone;

// Tạo mã QR từ vietqr.io
$qr_url = "https://img.vietqr.io/image/{$bank_code}-{$account_number}-qr_only.png?amount={$total}&addInfo={$transfer_content}&accountName=" . urlencode($account_name);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quét mã QR để chuyển khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 text-center">
        <h2>Vui lòng chuyển khoản</h2>
        <p><strong>Ngân hàng:</strong> Vietcombank</p>
        <p><strong>Số tài khoản:</strong> <?= $account_number ?></p>
        <p><strong>Chủ tài khoản:</strong> <?= $account_name ?></p>
        <p><strong>Số tiền:</strong> <?= number_format($total, 0, ',', '.') ?> VND</p>
        <p><strong>Nội dung chuyển khoản:</strong> <?= $transfer_content ?></p>

        <img src="<?= $qr_url ?>" width="300" alt="QR chuyển khoản">

        <div class="mt-4">
            <a href="ordercomplete.php" class="btn btn-primary">Tôi đã chuyển khoản</a>
        </div>
    </div>
</body>
</html>

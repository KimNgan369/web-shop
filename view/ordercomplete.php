<?php
session_start();

// Kiểm tra nếu không có thông tin đơn hàng thì chuyển hướng về trang chủ
if (!isset($_SESSION['order_info'])) {
    header("Location: ../index.php");
    exit();
}

$order = $_SESSION['order_info'];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif; /* Chon font chu Arial hoac sans-serif */
            background-color: #f8f9fa; /* Mau nen xam nhat cho trang web */
        }
        
    </style>
</head>
<body class="bg-light">
<main class="container-fluid py-3">
    <div>
        <div class="d-flex flex-wrap justify-content-center align-items-center text-center container-fluid py-3 bg-light">
            <div class="d-flex align-items-center m-2">
                <i class="bi bi-bag-dash-fill text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Shopping Cart</span>
            </div>
            <div class="d-flex align-items-center text-muted m-2">
                <span class="border-bottom border-3 mx-2 d-inline-block" style="width: 50px;"></span>
                <i class="bi bi-clipboard-check-fill text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Checkout</span>
            </div>
            <div class="d-flex align-items-center text-muted m-2">
                <span class="border-bottom border-3 mx-2 d-inline-block" style="width: 50px;"></span>
                <i class="bi bi-ticket-perforated-fill text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Order Complete</span>
            </div>
        </div>
    
        <div class="container-fluid bg-white p-4 rounded shadow-sm mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4">Your Order</h1>
                <div class="d-flex align-items-center text-success">
                    <i class="fas fa-check-circle"></i>
                    <span class="ms-2">Paid</span>
                </div>
            </div>
            <!-- <div class="border-bottom pb-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="image.jpg" alt="Product Image" class="me-2" style="width: 50px; height: 50px;">
                        <span>1x Hermes “CADUCEUS”</span>
                    </div>
                    <div class="text-start" style="width: 50px;">2x</div>
                    <span class="ms-4">$120.00</span>
                    <span>$240.00</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="image.jpg" alt="Product Image" class="me-2" style="width: 50px; height: 50px;">
                        <span>1x Hermes “CADUCEUS”</span>
                    </div>
                    <div class="text-start" style="width: 50px;">1x</div>
                    <span class="ms-4">$2.00</span>
                    <span>$2.00</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="image.jpg" alt="Product Image" class="me-2" style="width: 50px; height: 50px;">
                        <span>1x Hermes “CADUCEUS”</span>
                    </div>
                    <div class="text-start" style="width: 50px;">1x</div>
                    <span class="ms-4">$3.00</span>
                    <span>$3.00</span>
                </div>
            </div>
            
            <div class="border-bottom pb-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="image.jpg" alt="Product Image" class="me-2" style="width: 50px; height: 50px;">
                        <span>1x Hermes “CADUCEUS”</span>
                    </div>
                    <div class="text-start" style="width: 50px;">1x</div>
                    <span class="ms-4">$3.00</span>
                    <span>$3.00</span>
                </div>
            </div>
            <div class="border-bottom pb-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="image.jpg" alt="Product Image" class="me-2" style="width: 50px; height: 50px;">
                        <span>1x Hermes “CADUCEUS”</span>
                    </div>
                    <div class="text-start" style="width: 50px;">1x</div>
                    <span class="ms-4">$3.00</span>
                    <span>$3.00</span>
                </div>
            </div> -->

            <div class="border-bottom pb-4 mb-4">
                <?php foreach ($order['cart'] as $item): ?>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center">
                        <img src="../layout/img/<?= htmlspecialchars($item['image']) ?>" class="me-2" style="width: 50px; height: 50px;">
                        <span><?= htmlspecialchars($item['name']) ?></span>
                    </div>
                    <div class="text-start" style="width: 50px;"><?= $item['quantity'] ?>x</div>
                    <span class="ms-4"><?= number_format($item['price'], 0, ',', '.') ?>₫</span>
                    <span><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>₫</span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="d-flex justify-content-end align-items-center mb-4">
                <span class="fw-semibold text-danger fs-5 me-auto">TOTAL</span>
                <span class="ms-4 text-danger fs-5"><?= number_format($order['total'], 0, ',', '.') ?>₫</span>
            </div>


            <!-- <div class="border-bottom pb-4 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Shipping</span>
                            <span>HoChiMinhCity, VietNam</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Shipping Options</span>
                            <span>Same-Day Dispatching</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Email Money Transfer</span>
                            <span>Interac</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Subtotal</span>
                            <span>$497.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Discount</span>
                            <span>$0.0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Shipping Costs</span>
                            <span>$50.00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Point</span>
                            <span>-$250</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">TOTAL</span>
                            <span class="fw-semibold text-danger">$297.00</span>
                        </div>
                    </div>
                </div>
            </div> -->


            <div class="border-bottom pb-4 mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Họ tên</span>
                            <span><?= htmlspecialchars($order['customer']['first_name']) . ' ' . htmlspecialchars($order['customer']['last_name']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Địa chỉ</span>
                            <span><?= htmlspecialchars($order['customer']['address']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Tỉnh/Thành phố</span>
                            <span><?= htmlspecialchars($order['customer']['province']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Quận/Huyện</span>
                            <span><?= htmlspecialchars($order['customer']['district']) ?></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Số điện thoại</span>
                            <span><?= htmlspecialchars($order['customer']['phone']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Email</span>
                            <span><?= htmlspecialchars($order['customer']['email']) ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Ngày đặt hàng</span>
                            <span><?= $order['order_date'] ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Ghi chú</span>
                            <span><?= !empty($order['customer']['notes']) ? htmlspecialchars($order['customer']['notes']) : 'Không có' ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">TOTAL</span>
                            <span class="fw-semibold text-danger"><?= number_format($order['total'], 0, ',', '.') ?>₫</span>

                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <p class="mb-4">Mua tiếp, Nhấp vào nút bên dưới</p>
                <button class="btn btn-warning text-white rounded-pill" onclick="window.location.href='../index.php'">
                    Quay lại trang chủ
                </button>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
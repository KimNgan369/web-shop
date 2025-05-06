<?php
session_start();
include "../dao/products.php";

// Bật báo lỗi để debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kiểm tra nếu giỏ hàng trống thì chuyển hướng về trang giỏ hàng
if (empty($_SESSION['cart'])) {
    header("Location: index.php?pg=shoppingcart");
    exit();
}

// Tính toán tổng tiền
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping_cost = $subtotal >= 1000000 ? 0 : 50000;
$discount = $_SESSION['applied_coupon']['discount'] ?? 0;
$total = $subtotal - $discount + $shipping_cost;

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    // Lưu thông tin đơn hàng vào session
    $_SESSION['order_info'] = [
        'customer' => [
            'first_name' => $_POST['firstName'],
            'last_name' => $_POST['lastName'],
            'address' => $_POST['address'],
            'province' => $_POST['province'],
            'district' => $_POST['district'],
            'phone' => $_POST['phone'],
            'email' => $_POST['email'],
            'notes' => $_POST['orderNotes'] ?? '',
            'payment_method' => $_POST['paymentMethod'] ?? 'cod'
        ],
        'cart' => $_SESSION['cart'],
        'total' => $total,
        'order_date' => date('Y-m-d H:i:s')
    ];

    // Xóa giỏ hàng
    unset($_SESSION['cart']);

    // Nếu thanh toán chuyển khoản, chuyển đến trang mã QR
    if ($_POST['paymentMethod'] === 'bank') {
        header("Location: ../view/qrcode.php");
    } else {
        header("Location: ../view/ordercomplete.php");
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Thông tin giao hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="d-flex flex-wrap justify-content-center align-items-center text-center mt-n3">
            <div class="d-flex align-items-center m-2">
                <i class="bi bi-bag-dash-fill text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Giỏ hàng</span>
            </div>
            <div class="d-flex align-items-center text-muted m-2">
                <span class="border-bottom border-3 mx-2 d-inline-block" style="width: 50px;"></span>
                <i class="bi bi-clipboard-check-fill text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Thanh toán</span>
            </div>
            <div class="d-flex align-items-center text-muted m-2">
                <span class="border-bottom border-3 mx-2 d-inline-block" style="width: 50px;"></span>
                <i class="bi bi-ticket-perforated text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Hoàn tất</span>
            </div>
        </div>
        
        <div class="row">
            <!-- Form thông tin giao hàng -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title" style="border-bottom: 2px solid #b6b9bb; padding-bottom: 30px;">Thông tin giao hàng</h2>
                        <form method="POST" action="">
                            <div class="form-row row">
                                <div class="form-group col-md-6 mb-4">
                                    <label for="firstName">Họ *</label>
                                    <input class="form-control" id="firstName" name="firstName" required type="text"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Tên *</label>
                                    <input class="form-control" id="lastName" name="lastName" required type="text"/>
                                </div>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="address">Địa chỉ *</label>
                                <input class="form-control" id="address" name="address" required type="text" placeholder="Số nhà, tên đường"/>
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" id="address2" type="text" placeholder="Tòa nhà, căn hộ, số phòng (nếu có)"/>
                            </div>
                            
                            <div class="form-row row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="province">Tỉnh/Thành phố *</label>
                                    <select class="form-control" id="province" name="province" required>
                                        <option value="">Chọn tỉnh/thành</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="district">Quận/Huyện *</label>
                                    <select class="form-control" id="district" name="district" required>
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="phone">Số điện thoại *</label>
                                    <input class="form-control" id="phone" name="phone" required type="tel" pattern="[0-9]{10,11}" placeholder=""/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email *</label>
                                    <input class="form-control" id="email" name="email" required type="email"/>
                                </div>
                            </div>
                            
                            <div class="card-title mb-3" style="border-bottom: 2px solid #b6b9bb; padding-bottom: 10px;"></div>
                            
                            <div class="form-group">
                                <label for="orderNotes">Ghi chú đơn hàng (nếu có)</label>
                                <textarea class="form-control" id="orderNotes" name="orderNotes" rows="3" placeholder="Ví dụ: Giao hàng giờ hành chính"></textarea>
                            </div>
                    </div>
                </div>
            </div>
            
            <!-- Thông tin đơn hàng -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Tạm tính</span>
                                <span><?= number_format($subtotal, 0, ',', '.') ?>₫</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>Giảm giá</span>
                                <span><?= number_format($discount, 0, ',', '.') ?>₫</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>Phí vận chuyển</span>
                                <span><?= number_format($shipping_cost, 0, ',', '.') ?>₫</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3 fw-bold">
                            <span>Tổng cộng</span>
                            <span><?= number_format($total, 0, ',', '.') ?>₫</span>
                        </div>
                        
                        <div class="form-group form-check mt-4">
                            <input class="form-check-input" id="confirmAddress" type="checkbox" required/>
                            <label class="form-check-label" for="confirmAddress">
                                Tôi xác nhận địa chỉ giao hàng chính xác 100% và KHÔNG yêu cầu shop bồi thường nếu giao sai địa chỉ.
                            </label>
                        </div>
                        
                        <div class="form-group form-check">
                            <input class="form-check-input" id="emailUpdates" type="checkbox"/>
                            <label class="form-check-label" for="emailUpdates">Nhận thông báo khuyến mãi qua email (tùy chọn)</label>
                        </div>
                                                
                        <div class="text-muted small mt-4">THANH TOÁN AN TOÀN</div>
                            <div class="d-flex justify-content-center mt-2 gap-3 flex-column">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" value="bank" checked>
                                    <label class="form-check-label fw-bold" for="bankTransfer">
                                        Chuyển khoản ngân hàng
                                    </label>
                                    <div class="text-muted small ms-4">
                                        Thực hiện thanh toán vào ngay tài khoản ngân hàng của chúng tôi. Đơn hàng sẽ được giao sau khi đã chuyển tiền.
                                    </div>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" value="cod">
                                    <label class="form-check-label fw-bold" for="cashOnDelivery">
                                        Trả tiền mặt khi nhận được hàng
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="submit_order" class="btn btn-secondary btn-block mt-3">ĐẶT HÀNG | <?= number_format($total, 0, ',', '.') ?>₫</button>
                        </form> <!-- Đóng thẻ form ở đây -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        fetch("https://provinces.open-api.vn/api/?depth=1")
        .then(res => res.json())
        .then(data => {
            const provinceSelect = document.getElementById("province");
            data.forEach(province => {
                const option = document.createElement("option");
                option.value = province.code;
                option.textContent = province.name;
                provinceSelect.appendChild(option);
            });
        });

    // Load quận/huyện khi chọn tỉnh
    document.getElementById("province").addEventListener("change", function () {
        const provinceCode = this.value;
        const districtSelect = document.getElementById("district");
        districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';

        if (provinceCode) {
            fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                .then(res => res.json())
                .then(data => {
                    data.districts.forEach(district => {
                        const option = document.createElement("option");
                        option.value = district.code;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                });
        }
    });

    // Validate form trước khi submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!document.getElementById('confirmAddress').checked) {
            e.preventDefault();
            alert('Vui lòng xác nhận địa chỉ giao hàng');
        }
    });
    </script>
</body>
</html>
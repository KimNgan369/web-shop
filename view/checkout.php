<?php
session_start();
include_once "../dao/products.php";
include_once "../dao/pdo.php";
include_once "../dao/orders.php";

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if cart is empty, redirect to shopping cart
if (empty($_SESSION['cart'])) {
    header("Location: index.php?pg=shoppingcart");
    exit();
}

// Calculate totals
$subtotal = 0;
foreach ($_SESSION['cart'] as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$shipping_cost = $subtotal >= 50 ? 0 : 2.50;
$discount = $_SESSION['applied_coupon']['discount'] ?? 0;
$total = $subtotal - $discount + $shipping_cost;

// Get user_id from session if logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    // Generate unique order_code: ORD-YYYYMMDD-XXXX
    $date = date('Ymd');
    $conn = pdo_get_connection();
    do {
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $order_code = "ORD-{$date}-{$random}";
        $sql = "SELECT COUNT(*) FROM orders WHERE order_code = :order_code";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':order_code' => $order_code]);
        $exists = $stmt->fetchColumn();
    } while ($exists > 0);

    // Save order information to session
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
        'order_date' => date('Y-m-d H:i:s'),
        'order_code' => $order_code
    ];

    // Save to database
    $order_id = save_order_to_database(
        $_SESSION['order_info']['customer'],
        $_SESSION['cart'],
        $total,
        $_POST['paymentMethod'] ?? 'cod',
        $order_code,
        $user_id
    );
    
    if ($order_id) {
        // Clear cart
        unset($_SESSION['cart']);
        unset($_SESSION['applied_coupon']);
        
        // Redirect
        if ($_POST['paymentMethod'] === 'bank') {
            header("Location: ../view/qrcode.php?order_id=$order_id");
        } else {
            header("Location: ../view/ordercomplete.php?order_id=$order_id");
        }
        exit();
    } else {
        $error_message = "Error: Unable to save order. Please try again or contact support.";
        error_log("Checkout failed: Unable to save order. Order code: $order_code");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Shipping Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>
        
        <div class="d-flex flex-wrap justify-content-center align-items-center text-center mt-n3">
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
                <i class="bi bi-ticket-perforated text-success border border-white rounded-circle bg-light p-2"></i>
                <span class="font-weight-medium ml-2">Order Complete</span>
            </div>
        </div>
        
        <div class="row">
            <!-- Shipping Information Form -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title" style="border-bottom: 2px solid #b6b9bb; padding-bottom: 30px;">Shipping Information</h2>
                        <form method="POST" action="">
                            <div class="form-row row">
                                <div class="form-group col-md-6 mb-4">
                                    <label for="firstName">First Name *</label>
                                    <input class="form-control" id="firstName" name="firstName" required type="text"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Last Name *</label>
                                    <input class="form-control" id="lastName" name="lastName" required type="text"/>
                                </div>
                            </div>
                            
                            <div class="form-group mb-2">
                                <label for="address">Address *</label>
                                <input class="form-control" id="address" name="address" required type="text" placeholder="Street address"/>
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" id="address2" type="text" placeholder="Apartment, suite, unit (optional)"/>
                            </div>
                            
                            <div class="form-row row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="province">State/Province *</label>
                                    <select class="form-control" id="province" name="province" required>
                                        <option value="">Select state/province</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="district">District *</label>
                                    <select class="form-control" id="district" name="district" required>
                                        <option value="">Select district</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row row mb-3">
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone *</label>
                                    <input class="form-control" id="phone" name="phone" required type="tel" pattern="[0-9]{10,11}" placeholder=""/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email *</label>
                                    <input class="form-control" id="email" name="email" required type="email"/>
                                </div>
                            </div>
                            
                            <div class="card-title mb-3" style="border-bottom: 2px solid #b6b9bb; padding-bottom: 10px;"></div>
                            
                            <div class="form-group">
                                <label for="orderNotes">Order Notes (optional)</label>
                                <textarea class="form-control" id="orderNotes" name="orderNotes" rows="3" placeholder="Example: Deliver during business hours"></textarea>
                            </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal</span>
                                <span>$<?php echo number_format($subtotal, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>Discount</span>
                                <span>$<?php echo number_format($discount, 2); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>Shipping</span>
                                <span>$<?php echo number_format($shipping_cost, 2); ?></span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3 fw-bold">
                            <span>Total</span>
                            <span>$<?php echo number_format($total, 2); ?></span>
                        </div>
                        
                        <div class="form-group form-check mt-4">
                            <input class="form-check-input" id="confirmAddress" type="checkbox" required/>
                            <label class="form-check-label" for="confirmAddress">
                                I confirm the shipping address is 100% accurate and will NOT hold the shop responsible for delivery to the wrong address.
                            </label>
                        </div>
                        
                        <div class="form-group form-check">
                            <input class="form-check-input" id="emailUpdates" type="checkbox"/>
                            <label class="form-check-label" for="emailUpdates">Receive promotional emails (optional)</label>
                        </div>
                                                
                        <div class="text-muted small mt-4">SECURE PAYMENT</div>
                        <div class="d-flex justify-content-center mt-2 gap-3 flex-column">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" value="bank" checked>
                                <label class="form-check-label fw-bold" for="bankTransfer">
                                    Bank Transfer
                                </label>
                                <div class="text-muted small ms-4">
                                    Make payment directly to our bank account. Your order will be shipped after payment is received.
                                </div>
                            </div>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" value="cod">
                                <label class="form-check-label fw-bold" for="cashOnDelivery">
                                    Cash on Delivery
                                </label>
                            </div>
                        </div>
                        <button type="submit" name="submit_order" class="btn btn-secondary btn-block mt-3">PLACE ORDER | $<?php echo number_format($total, 2); ?></button>
                        </form>
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
                option.value = province.name;
                option.textContent = province.name;
                option.dataset.code = province.code;
                provinceSelect.appendChild(option);
            });
        });

        document.getElementById("province").addEventListener("change", function () {
            const provinceCode = this.selectedOptions[0].dataset.code;
            const districtSelect = document.getElementById("district");
            districtSelect.innerHTML = '<option value="">Select district</option>';

            if (provinceCode) {
                fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.districts) {
                            data.districts.forEach(district => {
                                const option = document.createElement("option");
                                option.value = district.name;
                                option.textContent = district.name;
                                districtSelect.appendChild(option);
                            });
                        }
                    });
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            if (!document.getElementById('confirmAddress').checked) {
                e.preventDefault();
                alert('Please confirm your shipping address');
            }
        });
    </script>
</body>
</html>
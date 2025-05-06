<?php
session_start();
include "../dao/products.php";

// XỬ LÝ THÊM VÀO GIỎ HÀNG KHI NHẬN ĐƯỢC POST
if (isset($_POST['addToCart'])) {
    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $product_id = (int)$_POST['id'];
    
    // Kiểm tra sản phẩm đã có trong giỏ chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += (int)$_POST['quantity'];
    } else {
        // Thêm sản phẩm mới vào giỏ
        $_SESSION['cart'][$product_id] = [
            'id' => $product_id,
            'name' => $_POST['name'],
            'price' => (float)$_POST['price'],
            'quantity' => (int)$_POST['quantity'],
            'image' => $_POST['image']
        ];
    }
    
    // Chuyển hướng để tránh submit lại form khi refresh
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Tính toán tổng tiền và phí vận chuyển
$subtotal = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }
}

$shipping_cost = $subtotal >= 100 ? 0 : 50;
$discount = $_SESSION['applied_coupon']['discount'] ?? 0;
$total = $subtotal - $discount + $shipping_cost;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .coupon-success {
            color: #28a745;
            font-weight: bold;
        }
        .coupon-error {
            color: #dc3545;
        }
        .cart-item {
            transition: all 0.3s ease;
        }
        .cart-item.removing {
            opacity: 0;
            transform: translateX(-100px);
        }
    </style>
</head>
<body>
<main class="container-fluid py-3">
    <!-- Phần header giỏ hàng -->
    <div>
            <div class="d-flex flex-wrap justify-content-center align-items-center text-center">
                <div class="d-flex align-items-center m-2">
                    <i class="bi bi-bag-dash-fill text-success border border-white rounded-circle bg-light p-2"></i>
                    <span class="font-weight-medium ml-2">Shopping Cart</span>
                </div>
                <div class="d-flex align-items-center text-muted m-2">
                    <span class="border-bottom border-3 mx-2 d-inline-block" style="width: 50px;"></span>
                    <i class="bi bi-clipboard-check text-success border border-white rounded-circle bg-light p-2"></i>
                    <span class="font-weight-medium ml-2">Checkout</span>
                </div>
                <div class="d-flex align-items-center text-muted m-2">
                    <span class="border-bottom border-3 mx-2 d-inline-block" style="width: 50px;"></span>
                    <i class="bi bi-ticket-perforated text-success border border-white rounded-circle bg-light p-2"></i>
                    <span class="font-weight-medium ml-2">Order Complete</span>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <h2 class="h5 font-weight-bold mb-4">Your Cart</h2>
                <div class="mb-4">
                    <?php 
                    if (isset($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item): 
                            $subtotal_item = $item['price'] * $item['quantity'];
                    ?>
                    <div class="d-flex justify-content-between border-bottom pb-3 align-items-center cart-item" 
                        data-price="<?= $item['price'] ?>" 
                        data-id="<?= $item['id'] ?>">
                        
                        <div class="d-flex align-items-center gap-2">
                            <input type="checkbox" class="form-check-input product-checkbox" 
                                data-id="<?= $item['id'] ?>" checked>
                        </div>
                        
                        <div class="d-flex align-items-center gap-3">
                            <img src="../layout/img/<?= htmlspecialchars($item['image']) ?>" width="50">
                            <span><?= htmlspecialchars($item['name']) ?></span>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <button class="btn btn-outline-secondary btn-sm minus-btn" 
                                    data-id="<?= $item['id'] ?>">-</button>
                            <span class="mx-2 quantity"><?= $item['quantity'] ?></span>
                            <button class="btn btn-outline-secondary btn-sm plus-btn" 
                                    data-id="<?= $item['id'] ?>">+</button>
                        </div>
                        
                        <span class="d-flex align-items-center product-price">
                            $<?= number_format($subtotal_item, 2) ?>
                        </span>
                    </div>
                    <?php 
                        endforeach;
                    } else {
                        echo "<p class='text-center py-3'>Giỏ hàng trống</p>";
                    }
                    ?>
                    <div class="text-end mt-3">
                        <button id="remove-selected-btn" class="btn btn-danger mt-3">
                            🗑️ Delete selected items
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Phần thông tin vận chuyển -->
            <div class="bg-white p-4 rounded shadow-sm">
                <!-- ... (giữ nguyên phần delivery info) ... -->
                <div class="d-flex justify-content-between">
                    <h3 class="h6 font-weight-bold text-success">Delivery</h3>
                    <h3 class="h6 font-weight-bold text-success" style="margin-right: 120px;">Free Returns</h3>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded shadow-sm d-flex flex-column h-100">
                            <div class="d-flex justify-content-start mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center border border-white rounded-circle bg-light" style="width: 50px; height: 50px;">
                                    <i class="bi bi-bookmark-dash text-success fs-3"></i>
                                </div>
                            </div>
                            <p class="mt-2">Order by 10pm for free next day delivery on Orders over $100</p>
                            <p class="text-muted mt-1">We deliver Monday to Saturday - excluding Holidays</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded shadow-sm d-flex flex-column h-100">
                            <div class="d-flex justify-content-start mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center border border-white rounded-circle bg-light" style="width: 50px; height: 50px;">
                                    <i class="bi bi-box-seam-fill text-success fs-3"></i>
                                </div>                                
                            </div>
                            <p class="mt-2">Free next day delivery to stores.</p>
                            <p class="text-muted mt-1">Home delivery is $4.99 for orders under $100 and is FREE for all orders over $100</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded shadow-sm d-flex flex-column h-100">
                            <div class="d-flex justify-content-start mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center border border-whitewhite rounded-circle bg-light" style="width: 50px; height: 50px;">
                                    <i class="bi bi-car-front text-success fs-3"></i>
                                </div>
                            </div>
                            <p class="mt-2">30 days to return it to us for a refund.We have made returns SO EASY - you can now return your order to a store or send it with FedEx FOR FREE </p>
                            <p class="mt-1"></p>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
        
        <!-- Phần thanh toán -->
        <div class="col-lg-4 bg-white p-4 rounded shadow-sm mt-4 mt-lg-0">
            <div class="mb-4">
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <span class="cart-subtotal">$<?= number_format($subtotal, 2) ?></span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Discount</span>
                    <span class="cart-discount">$<?= number_format($discount, 2) ?></span>
                </div>

                <div class="d-flex justify-content-between">
                    <span>Shipping Costs</span>
                    <span class="shipping-cost">$<?= number_format($shipping_cost, 2) ?></span>
                </div>
                
                <div class="d-flex justify-content-between mt-3 fw-bold">
                    <span>Total</span>
                    <span class="cart-total">$<?= number_format($total, 2) ?></span>
                </div>
            </div>
            
            <div class="d-flex align-items-center mb-4">
                <input 
                    id="coupon-code-input" 
                    class="form-control me-2" 
                    placeholder="Coupon code" 
                    type="text" 
                    style="max-width: 250px;"
                    value="<?= $_SESSION['applied_coupon']['code'] ?? '' ?>"
                />
                <button 
                    id="apply-coupon-btn" 
                    class="btn fw-bold text-success border border-white rounded-pill bg-success bg-opacity-10 px-4 py-2"
                >
                    Apply Coupon
                </button>
            </div>
            <div id="coupon-message" class="mb-3"></div>

            <div class="text-success mb-3">
                Get Free Shipping for orders over
                <span class="text-danger">$100.00</span>
            </div>
            <a class="text-primary d-block mb-2" href="#">Continue Shopping</a>
            <button class="btn btn-success btn-block w-100 fw-bold py-3 checkout-btn" 
                    onclick="window.location.href='checkout.php'">
                Checkout ! $<?= number_format($total, 2) ?>
            </button>
            
            
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm định dạng tiền tệ
    function formatCurrency(amount) {
        return '$' + amount.toFixed(2);
    }

    // Hàm hiển thị thông báo
    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);
        setTimeout(() => alertDiv.remove(), 3000);
    }

    // Hàm tính và cập nhật tổng tiền
    function updateCartTotal() {
        let subtotal = 0;
        
        document.querySelectorAll('.cart-item').forEach(item => {
            if (item.querySelector('.product-checkbox').checked) {
                const price = parseFloat(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity').textContent);
                subtotal += price * quantity;
            }
        });
        
        // Tính phí vận chuyển
        const shippingCost = subtotal >= 100 ? 0 : 50;
        
        // Cập nhật UI
        document.querySelector('.cart-subtotal').textContent = formatCurrency(subtotal);
        document.querySelector('.shipping-cost').textContent = formatCurrency(shippingCost);
        
        // Tính tổng cuối cùng (có thể cập nhật discount từ coupon sau)
        const discount = parseFloat(document.querySelector('.cart-discount').textContent.replace('$', '')) || 0;
        const total = subtotal - discount + shippingCost;
        
        document.querySelector('.cart-total').textContent = formatCurrency(total);
        document.querySelector('.checkout-btn').textContent = 'Checkout ! ' + formatCurrency(total);
        
        return subtotal;
    }

    // Xử lý sự kiện click cho nút +/-
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('plus-btn')) {
            e.preventDefault();
            const productId = e.target.dataset.id;
            updateQuantity(productId, 1);
        }
        
        if (e.target.classList.contains('minus-btn')) {
            e.preventDefault();
            const productId = e.target.dataset.id;
            updateQuantity(productId, -1);
        }
    });

    // Hàm cập nhật số lượng
    function updateQuantity(productId, change) {
        const container = document.querySelector(`button[data-id="${productId}"]`).closest('.cart-item');
        const quantityElement = container.querySelector('.quantity');
        const priceElement = container.querySelector('.product-price');
        let currentQuantity = parseInt(quantityElement.textContent);
        let newQuantity = currentQuantity + change;
        const price = parseFloat(container.dataset.price);

        if (newQuantity < 1) {
            showAlert('warning', 'Quantity cannot be less than 1');
            return;
        }

        fetch('updatecart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                id: productId,
                change: change
            })
        })
        .then(response => {
            if (!response.ok) throw new Error('Connection error');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                quantityElement.textContent = newQuantity;
                priceElement.textContent = formatCurrency(price * newQuantity);
                updateCartTotal();
                
                if (change > 0) {
                    showAlert('success', 'Quantity increased');
                } else {
                    showAlert('success', 'Quantity decreased');
                }
            } else {
                throw new Error(data.message || 'Update failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', error.message);
            quantityElement.textContent = currentQuantity;
        });
    }

    // Xử lý xóa nhiều sản phẩm
    const removeSelectedBtn = document.getElementById('remove-selected-btn');
    if (removeSelectedBtn) {
        removeSelectedBtn.addEventListener('click', async function() {
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            
            if (checkedBoxes.length === 0) {
                showAlert('warning', 'Please select at least 1 product to delete!');
                return;
            }

            if (!confirm('Are you sure you want to delete selected products?')) return;

            try {
                removeSelectedBtn.disabled = true;
                removeSelectedBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Deleting...';
                
                const productIds = Array.from(checkedBoxes).map(checkbox => checkbox.dataset.id);
                
                const response = await fetch('updatecart.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'ids=' + encodeURIComponent(JSON.stringify(productIds))
                });

                const result = await response.json();
                if (!result.success) throw new Error(result.message || 'Delete failed');

                // Thêm hiệu ứng xóa mượt mà
                checkedBoxes.forEach(checkbox => {
                    const item = checkbox.closest('.cart-item');
                    item.classList.add('removing');
                    setTimeout(() => item.remove(), 300);
                });
                
                updateCartTotal();
                showAlert('success', `Deleted ${productIds.length} products successfully!`);
            } catch (error) {
                console.error('Error:', error);
                showAlert('danger', error.message || 'Error occurred while deleting');
            } finally {
                removeSelectedBtn.disabled = false;
                removeSelectedBtn.innerHTML = '🗑️ Delete selected items';
            }
        });
    }

    // Xử lý áp dụng coupon
    const applyCouponBtn = document.getElementById('apply-coupon-btn');
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function() {
            const couponCode = document.getElementById('coupon-code-input').value.trim();
            const subtotal = updateCartTotal();
            const couponMessage = document.getElementById('coupon-message');
            
            if (!couponCode) {
                couponMessage.innerHTML = '<span class="coupon-error">Please enter coupon code</span>';
                return;
            }

            applyCouponBtn.disabled = true;
            applyCouponBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Applying...';

            fetch('apply_coupon.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    coupon_code: couponCode,
                    subtotal: subtotal
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    couponMessage.innerHTML = `<span class="coupon-success">${data.message}</span>`;
                    document.querySelector('.cart-discount').textContent = formatCurrency(data.discount);
                    updateCartTotal();
                } else {
                    couponMessage.innerHTML = `<span class="coupon-error">${data.message}</span>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                couponMessage.innerHTML = '<span class="coupon-error">Error applying coupon</span>';
            })
            .finally(() => {
                applyCouponBtn.disabled = false;
                applyCouponBtn.innerHTML = 'Apply Coupon';
            });
        });
    }

    // Cập nhật tổng tiền khi trang được tải
    updateCartTotal();
});
</script>
</body>
</html>
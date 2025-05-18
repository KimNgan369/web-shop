<?php
session_start();
include "../dao/products.php";
include "../dao/global.php";
include "header.php";


$id = $_GET['id'] ?? 0;
$id = (int)$id;

if ($id <= 0) {
    die("<div class='alert alert-danger'>ID sản phẩm không hợp lệ</div>");
}

// Lấy thông tin sản phẩm
$product = get_sp_by_id($id);

if (!$product) {
    die("<div class='alert alert-warning'>Không tìm thấy sản phẩm</div>");
}

// Kiểm tra ảnh tồn tại
$image_path = IMG_PATH_ADMIN . $product['image'];
if (!file_exists($image_path)) {
    die("<div class='alert alert-warning'>Ảnh sản phẩm không tồn tại</div>");
}

// Kết nối database để lấy ảnh sản phẩm khác (nếu cần)
$conn = new mysqli("localhost", "root", "", "myjewelryshop");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách ảnh (bao gồm ảnh chính và 4 ảnh khác)
$thumbnails = [IMG_PATH_ADMIN . $product['image']]; // Ảnh chính

$sql = "SELECT image FROM products WHERE id != ? LIMIT 4"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $thumbnails[] = IMG_PATH_ADMIN . $row['image'];
    }
}
$stmt->close();
$conn->close();

?>

<?php include "header1.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYTH Rings</title>

    <!-- Bootstrap, CSS, Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../layout/css/home.css">
    <link rel="stylesheet" href="../layout/css/ring_detail.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body { padding-top: 80px; }
        .navbar { background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .custom-add-to-cart {
            background-color: #ffc107;
            color: black;
            border: none;
        }
        .custom-add-to-cart:hover {
            background-color: #e0a800;
            color: black;
        }
        .quantity-control button {
            line-height: 1;
        }
        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .quantity-input {
            -moz-appearance: textfield;
        }
    </style>
</head>
<div id="cartIcon" style="position: fixed; top: 20px; right: 20px; display: none; z-index: 9999;">
    <i class="bi bi-cart-fill" style="font-size: 2rem; color: orange;"></i>
</div>
<body>
        <form action="" method="post">
            <input type="hidden" name="id">
            <input type="hidden" name="name">
            <input type="hidden" name="description">
            <input type="hidden" name="price">
            <input type="hidden" name="image">
            <input type="hidden" name="quantity">

        </form>

        <!-- Navbar -->
<nav class="navbar navbar-light fixed-top">
    <div class="container">
        <div class="logo-container" onclick="window.location.href='../index.php'" style="cursor: pointer;">
            <img src="<?= (basename($_SERVER['PHP_SELF']) == 'rings.php' ? '../' : '') ?>../layout/img/LOGO.png"
                alt="MYTH" class="logo" style="width: 50px; height: 50px; object-fit: contain;">
            <span class="brand-name">MYTH</span>
        </div>

        <div class="navigation-links">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="?pg=shop">Shop</a></li>
                <li><a href="#">Contacts</a></li>
            </ul>
        </div>
        <div class="signup-container">
            <button class="sign-up-btn">
                <a href="sign_up.php" class="text-white text-decoration-none">SIGN UP</a>
            </button>
        </div>        
    </div>
</nav>

<div style="margin-left: 15px; margin-top: 20px;">
    <button class="btn btn-warning text-dark" style="border-radius: 50%; width: 50px; height: 50px;" onclick="history.back()">
        <i class="bi bi-arrow-left" style="font-size: 1.5rem;"></i>
    </button>
</div>

<!-- Main Content -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <div class="main-image-container position-relative">
                <div class="main-image">
                    <img src="<?= $thumbnails[0] ?>" class="img-fluid" alt="Product Image">
                    <div class="try-now">
                        <i class="bi bi-camera"></i> Try Now
                    </div>
                </div>
                <button class="carousel-arrow left-arrow">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-arrow right-arrow">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
            <div class="thumbnail-carousel d-flex align-items-center mt-3">
                <button class="carousel-arrow left-arrow">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="thumbnail-container d-flex flex-wrap">
                    <?php foreach ($thumbnails as $thumb): ?>
                        <img src="<?= $thumb ?>" class="thumbnail mx-2" style="width: 150px; height: 100px; object-fit: cover;" alt="Thumbnail">
                    <?php endforeach; ?>
                </div>
                <button class="carousel-arrow right-arrow">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- <div class="col-md-6">
            <h2 class="fw-bold">Zeus <span class="text-dark">‘THUNDER’</span></h2>
            <p class="text-muted">Inspired by Zeus, this ring features a bold lightning bolt and intricate cloud patterns, symbolizing strength and protection. Its sharp design and premium materials create a powerful and masculine look.</p>
            <h3 class="fw-bold">$100</h3>
            <div class="my-3">
                <span class="fw-bold">Color</span><br>
                <button class="btn btn-light rounded-circle me-2" style="width: 30px; height: 30px;"></button>
                <button class="btn btn-warning rounded-circle me-2" style="width: 30px; height: 30px;"></button>
                <button class="btn btn-secondary rounded-circle" style="width: 30px; height: 30px;"></button>
            </div>
            <div class="my-3">
                <span class="fw-bold">Size</span><br>
                <button class="btn btn-outline-dark me-1">7</button>
                <button class="btn btn-outline-dark me-1">8</button>
                <button class="btn btn-outline-dark me-1">9</button>
                <button class="btn btn-outline-dark me-1">10</button>
                <button class="btn btn-outline-dark">11</button>
            </div>
        <div class="d-flex flex-column gap-3 mt-4">
            <div class="d-flex gap-3 mt-4">
                <span class="me-2 fw-bold">Quantity:</span>
                <button class="btn btn-outline-secondary quantity-minus px-3 py-1">-</button>
                <input type="number" class="form-control quantity-input text-center mx-1" value="1" min="1" style="width: 60px;">
                <button class="btn btn-outline-secondary quantity-plus px-3 py-1">+</button>
            </div>
            <div class="d-flex gap-3 mt-4">
                <button id="addToCartBtn" class="btn custom-add-to-cart fw-bold px-4 py-2">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
                <a href="cart_new_page.php" class="btn btn-warning fw-bold px-4 py-2 text-decoration-none text-dark">
                    <i class="bi bi-bag-fill"></i> Buy Now
                </a>
            </div>
        </div> 
            <div id="cartIcon" style="position: fixed; top: 20px; right: 20px; display: none; z-index: 9999;">
                <i class="bi bi-cart-fill" style="font-size: 2rem; color: orange;"></i>
            </div>
        </div> -->
        <div class="col-md-6">
            <h2 class="fw-bold"><?= htmlspecialchars($product['name']) ?></h2>
            <p class="text-muted"><?= htmlspecialchars($product['description']) ?></p>
            <h3 class="fw-bold">$<?= number_format($product['price'], 2) ?></h3>
            <div class="my-3">
                <span class="fw-bold">Color</span><br>
                <button class="btn btn-light rounded-circle me-2" style="width: 30px; height: 30px;"></button>
                <button class="btn btn-warning rounded-circle me-2" style="width: 30px; height: 30px;"></button>
                <button class="btn btn-secondary rounded-circle" style="width: 30px; height: 30px;"></button>
            </div>
            <div class="my-3">
                <span class="fw-bold">Size</span><br>
                <button class="btn btn-outline-dark me-1">7</button>
                <button class="btn btn-outline-dark me-1">8</button>
                <button class="btn btn-outline-dark me-1">9</button>
                <button class="btn btn-outline-dark me-1">10</button>
                <button class="btn btn-outline-dark">11</button>
            </div>
            <form action="<?= $base_url ?>/shoppingcart.php" method="post">
                <div class="d-flex flex-column gap-3 mt-4">
                    <div class="d-flex gap-3 mt-4">
                        <span class="me-2 fw-bold">Quantity:</span>
                        <button type="button" class="btn btn-outline-secondary quantity-minus px-3 py-1">-</button>
                        <input type="number" name="quantity" id="quantityInput" class="form-control quantity-input text-center mx-1" value="1" min="1" style="width: 60px;">
                        <button type="button" class="btn btn-outline-secondary quantity-plus px-3 py-1">+</button>
                    </div>
                    <div class="d-flex gap-3 mt-4">
                        <button type="submit" id="addToCartBtn" name="addToCart" class="btn custom-add-to-cart fw-bold px-4 py-2">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <a href="" class="btn btn-warning fw-bold px-4 py-2 text-decoration-none text-dark">
                            <i class="bi bi-bag-fill"></i> Buy Now
                        </a>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="price" value="<?= $product['price'] ?>">
                <input type="hidden" name="image" value="<?= htmlspecialchars($product['image']) ?>">
                <input type="hidden" name="addToCart" value="1">
            </form>

        </div>
    </div>
</div>


<!-- Footer -->
<footer class="footer bg-light py-5">
    <div class="container d-flex flex-column align-items-center">
        <div class="text-center mb-5">
            <h4 class="fw-bold">About us</h4>
            <p class="text-muted">Order now and you will be satisfied</p>
        </div>

        <div class="row w-100">
            <div class="col-md-4 d-flex flex-column align-items-center text-center mb-4">
                <div class="icon-circle mb-3">
                    <img src="../layout/img/LOGO.png" alt="Large Assortment" class="icon-img" style="width: 50px;">
                </div>
                <h5 class="fw-bold">Large Assortment</h5>
                <p class="text-muted text-center">We offer many different types of products with fewer variations in each category.</p>
            </div>

            <div class="col-md-4 d-flex flex-column align-items-center text-center mb-4">
                <div class="icon-circle mb-3">
                    <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">Fast & Free Shipping</h5>
                <p class="text-muted text-center">4-day or less delivery time, free shipping and an expedited delivery option.</p>
            </div>

            <div class="col-md-4 d-flex flex-column align-items-center text-center mb-4">
                <div class="icon-circle mb-3">
                    <i class="bi bi-telephone" style="font-size: 2rem;"></i>
                </div>
                <h5 class="fw-bold">24/7 Support</h5>
                <p class="text-muted text-center">Answers to any business-related inquiry 24/7 and in real-time.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Đảm bảo tất cả code JavaScript chạy sau khi DOM đã tải xong
document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = <?= json_encode($thumbnails); ?>;
    let currentIndex = 0;

    const mainImageContainer = document.querySelector('.main-image-container');
    const mainImage = document.querySelector('.main-image img');
    const leftArrow = document.querySelector('.main-image-container .left-arrow');
    const rightArrow = document.querySelector('.main-image-container .right-arrow');
    const thumbnailImages = document.querySelectorAll('.thumbnail');
    const addToCartBtn = document.getElementById('addToCartBtn');
    const cartIcon = document.getElementById('cartIcon');
    const tryNowBtn = document.querySelector('.try-now');
    const quantityMinus = document.querySelector('.quantity-minus');
    const quantityPlus = document.querySelector('.quantity-plus');
    const quantityInput = document.querySelector('.quantity-input');

    // Chỉ thực hiện nếu các phần tử tồn tại
    if (mainImage) {
        const originalMainImageHTML = document.querySelector('.main-image').innerHTML;

        function updateMainImage() {
            mainImage.src = thumbnails[currentIndex];
        }

        updateMainImage();

        if (leftArrow) {
            leftArrow.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
                updateMainImage();
            });
        }

        if (rightArrow) {
            rightArrow.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % thumbnails.length;
                updateMainImage();
            });
        }

        thumbnailImages.forEach((thumb, index) => {
            thumb.addEventListener('click', () => {
                currentIndex = index;
                updateMainImage();
            });
        });
    }

    // Xử lý Add to Cart
    if (addToCartBtn && mainImage && cartIcon) {
        addToCartBtn.addEventListener('click', function(e) {
            // Ngăn form submit nếu là button type="submit"
            if (addToCartBtn.type === 'submit') {
                e.preventDefault();
            }

            const quantity = quantityInput ? quantityInput.value : 1;
            console.log('Add to cart with quantity:', quantity);

            // Hiệu ứng thêm vào giỏ hàng
            const img = mainImage.cloneNode(true);
            Object.assign(img.style, {
                position: 'fixed',
                top: mainImage.getBoundingClientRect().top + 'px',
                left: mainImage.getBoundingClientRect().left + 'px',
                width: mainImage.offsetWidth + 'px',
                height: mainImage.offsetHeight + 'px',
                transition: 'all 1s ease-in-out',
                zIndex: '1000'
            });

            document.body.appendChild(img);

            setTimeout(() => {
                Object.assign(img.style, {
                    top: '20px',
                    left: '90%',
                    width: '50px',
                    height: '50px',
                    opacity: '0.5'
                });
            }, 10);

            setTimeout(() => {
                img.remove();
                cartIcon.style.display = 'block';
                cartIcon.classList.add('animate__animated', 'animate__bounce');
                setTimeout(() => {
                    cartIcon.classList.remove('animate__animated', 'animate__bounce');
                }, 1000);
                
                // Nếu là button thường thì submit form
                if (addToCartBtn.type === 'submit') {
                    addToCartBtn.closest('form').submit();
                }
            }, 1000);
        });
    }

    // Xử lý Try Now
    if (tryNowBtn) {
        tryNowBtn.addEventListener('click', () => {
            const mainImageDiv = document.querySelector('.main-image');
            if (mainImageDiv) {
                mainImageDiv.innerHTML = `
                    <div style="position: relative;">
                        <video id="cameraStream" autoplay style="width: 100%; height: auto; border-radius: 10px; transform: scaleX(-1);"></video>
                        <img src="../layout/img/hand_frame.png" alt="Hand Frame" 
                            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60%; opacity: 0.5;">
                        <button id="closeCamera" class="btn btn-danger" 
                            style="position: absolute; top: 10px; right: 10px; border-radius: 50%; width: 40px; height: 40px;">
                            &times;
                        </button>
                        <button id="switchCamera" class="btn btn-warning" 
                            style="position: absolute; bottom: 10px; right: 10px; border-radius: 10px;">
                            Switch Camera
                        </button>
                    </div>
                `;

                let currentStream = null;
                let usingFrontCamera = true;

                function startCamera(facingMode = "user") {
                    if (currentStream) {
                        currentStream.getTracks().forEach(track => track.stop());
                    }
                    navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
                        .then(stream => {
                            currentStream = stream;
                            const video = document.getElementById('cameraStream');
                            if (video) {
                                video.srcObject = stream;
                                video.style.transform = facingMode === "user" ? "scaleX(-1)" : "scaleX(1)";
                            }
                        })
                        .catch(err => {
                            console.error("Không thể truy cập camera:", err);
                            mainImageDiv.innerHTML = '<p class="text-danger">Không thể bật camera!</p>';
                        });
                }

                startCamera();

                mainImageDiv.addEventListener('click', (e) => {
                    if (e.target.id === 'closeCamera') {
                        if (currentStream) {
                            currentStream.getTracks().forEach(track => track.stop());
                        }
                        mainImageDiv.innerHTML = originalMainImageHTML;
                        if (mainImage) updateMainImage();
                    }

                    if (e.target.id === 'switchCamera') {
                        usingFrontCamera = !usingFrontCamera;
                        startCamera(usingFrontCamera ? "user" : "environment");
                    }
                });
            }
        });
    }

    // Xử lý quantity
    if (quantityMinus && quantityInput) {
        quantityMinus.addEventListener('click', function() {
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
            }
        });
    }

    if (quantityPlus && quantityInput) {
        quantityPlus.addEventListener('click', function() {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
    }
    // Cập nhật hidden quantity khi số lượng thay đổi
if (quantityInput) {
    quantityInput.addEventListener('change', function() {
        document.getElementById('hiddenQuantity').value = this.value;
    });
}
});
</script>



</body>
</html>

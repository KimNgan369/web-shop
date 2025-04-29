<?php
include "../dao/products.php";

// Kết nối database
$conn = new mysqli("localhost", "root", "", "myjewelryshop");
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách ảnh
$sql = "SELECT image FROM products LIMIT 4"; 
$result = $conn->query($sql);

$thumbnails = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $thumbnails[] = "../layout/img/" . $row['image'];
    }
}
$conn->close();
?>

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
    </style>
</head>

<body>

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
                <a href="sign_in.php" class="text-white text-decoration-none">SIGN UP</a>
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

        <div class="col-md-6">
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
            <div class="d-flex gap-3 mt-4">
                <button id="addToCartBtn" class="btn custom-add-to-cart fw-bold px-4 py-2">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
                <a href="cart_new_page.php" class="btn btn-warning fw-bold px-4 py-2 text-decoration-none text-dark">
                    <i class="bi bi-bag-fill"></i> Buy Now
                </a>
            </div>

            <div id="cartIcon" style="position: fixed; top: 20px; right: 20px; display: none; z-index: 9999;">
                <i class="bi bi-cart-fill" style="font-size: 2rem; color: orange;"></i>
            </div>

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

const originalMainImageHTML = document.querySelector('.main-image').innerHTML;

function updateMainImage() {
    mainImage.src = thumbnails[currentIndex];
}

document.addEventListener('DOMContentLoaded', () => {
    updateMainImage();
});

leftArrow.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
    updateMainImage();
});

rightArrow.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % thumbnails.length;
    updateMainImage();
});

thumbnailImages.forEach((thumb, index) => {
    thumb.addEventListener('click', () => {
        currentIndex = index;
        updateMainImage();
    });
});

addToCartBtn.addEventListener('click', () => {
    const img = mainImage.cloneNode(true);
    img.style.position = 'fixed';
    img.style.top = mainImage.getBoundingClientRect().top + 'px';
    img.style.left = mainImage.getBoundingClientRect().left + 'px';
    img.style.width = mainImage.offsetWidth + 'px';
    img.style.height = mainImage.offsetHeight + 'px';
    img.style.transition = 'all 1s ease-in-out';
    img.style.zIndex = '1000';

    document.body.appendChild(img);

    setTimeout(() => {
        img.style.top = '20px';
        img.style.left = '90%';
        img.style.width = '50px';
        img.style.height = '50px';
        img.style.opacity = '0.5';
    }, 10);

    setTimeout(() => {
        img.remove();
        cartIcon.style.display = 'block';
        cartIcon.classList.add('animate__animated', 'animate__bounce');
        setTimeout(() => {
            cartIcon.classList.remove('animate__animated', 'animate__bounce');
        }, 1000);
    }, 1000);
});

// Try Now - Bật Camera
// Try Now - Bật Camera
tryNowBtn.addEventListener('click', () => {
    const mainImageDiv = document.querySelector('.main-image');
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
    let usingFrontCamera = true; // Mặc định dùng camera trước

    function startCamera(facingMode = "user") {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
        navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
            .then(stream => {
                currentStream = stream;
                const video = document.getElementById('cameraStream');
                video.srcObject = stream;
                if (facingMode === "user") {
                    video.style.transform = "scaleX(-1)"; // Mirror nếu là camera trước
                } else {
                    video.style.transform = "scaleX(1)"; // Không mirror nếu là camera sau
                }
            })
            .catch(err => {
                console.error("Không thể truy cập camera:", err);
                mainImageDiv.innerHTML = '<p class="text-danger">Không thể bật camera!</p>';
            });
    }

    startCamera(); // Bắt đầu với camera trước

    mainImageDiv.addEventListener('click', (e) => {
        if (e.target.id === 'closeCamera') {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }
            mainImageDiv.innerHTML = originalMainImageHTML;
            updateMainImage();
        }

        if (e.target.id === 'switchCamera') {
            usingFrontCamera = !usingFrontCamera;
            startCamera(usingFrontCamera ? "user" : "environment");
        }
    });
});


</script>

</body>
</html>

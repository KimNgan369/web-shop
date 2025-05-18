<?php
if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
    extract($_SESSION['s_user']);
    $html_account='<div class="signup-container" style="display: flex; gap: 10px;">
                    <button class="sign-up-btn">
                        <a href="?pg=myacc" class="text-white text-decoration-none">'.$username.'</a>
                    </button>
                    <button class="btn btn-outline-dark border-dark">
                        <a href="?pg=logout" class="text-danger text-decoration-none">LOGOUT</a>
                    </button>
                </div>';
} else {
    $html_account='<div class="signup-container" style="display: flex; gap: 10px;">
            <button class="sign-up-btn">
                <a href="?pg=signup" class="text-white text-decoration-none">SIGN UP</a>
            </button>
            <button class="btn btn-outline-warning border-dark">
                <a href="?pg=dangnhap" class="text-black text-decoration-none">LOGIN</a>
            </button>
        </div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>MYTH Store</title> 
    
    <!-- Import Bootstrap tu CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="layout/css/home.css">
    <link rel="stylesheet" href="layout/css/shop.css">
    
    <!-- Import font Roboto tu Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    
    <!-- Import Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
        body, html, nav, .navbar, .navigation-links, ul, li, a, button, .sign-up-btn {
            font-family: 'Roboto', sans-serif !important;
        }

        .navigation-links ul li a {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>

    <!-- Thanh dieu huong -->
    <nav class="navbar navbar-light fixed-top">
        <div class="container">
        <div class="logo-container">
        <img src="<?= (basename($_SERVER['PHP_SELF']) == 'rings.php' ? '../' : '') ?>layout/img/LOGO.png"
            alt="MYTH"
            class="logo"
            style="width: 50px; height: 50px; object-fit: contain;">
            <span class="brand-name">MYTH</span>
        </div>
        
        <div class="navigation-links">
            <ul>
                <li><a href="?pg=home">Home</a></li>
                <li><a href="?pg=shop">Shop</a></li>
                <li><a href="?pg=contacts">Contacts</a></li>
            </ul>
        </div>
        
        <?= $html_account; ?>
        </div>
    </nav>
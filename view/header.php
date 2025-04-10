<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>MYTH Store</title> 
    
    <!-- Import Bootstrap tu CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="layout/css/home.css">
    <link rel="stylesheet" href="layout/css/shop.css">
    
    <!-- Import font Poppins tu Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&display=swap" rel="stylesheet">
    
    <!-- Import Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

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
                <li><a href="index.php">Home</a></li>
                <li><a href="?pg=shop">Shop</a></li>
                <li><a href="#">Contacts</a></li>
            </ul>
        </div>
        
        <div class="signup-container">
            <button class="sign-up-btn">SIGN UP</button>

            <!-- <div class="navbar-left mx-auto">
                <img src="layout/img/logo.png" alt="MYTH Logo" width="50"> 
                <span class="fw-bold">MYTH</span> 
            </div> -->
            
        <!-- Navbar menu -->
        <!-- <ul class="navbar-center">
            <li class="nav-item"><a href="?pg=home" class="nav-link">Home</a></li> 
            <li class="nav-item">
                <a href="?pg=shop" class="nav-link">Shop</a>
                <ul class="dropdown">
                    <li><a href="?pg=shop&category=rings" class="dropdown-item">RINGS</a></li> 
                    <li><a href="?pg=shop&category=earrings" class="dropdown-item">EARRINGS</a></li>
                    <li><a href="?pg=shop&category=necklaces" class="dropdown-item">NECKLACES</a></li> 
                    <li><a href="?pg=shop&category=bracelets" class="dropdown-item">BRACELETS</a></li> 
                </ul>
            </li>                
            <li class="nav-item"><a href="?pg=contacts" class="nav-link">Contacts</a></li> 
        </ul> -->

        <!-- <nav>
            <a href="?pg=shop" class="nav-link">Shop</a>
            <ul class="dropdown">
                <li><a href="#">Home</a></li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Contacts</a></li>
            </ul>
        </nav> -->


        <!-- Navbar menu -->
        <!-- <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item dropdown">
                    <a href="?pg=shop" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Shop</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">RINGS</a>
                        <a class="dropdown-item" href="#">EARRINGS</a>
                        <a class="dropdown-item" href="#">NECKLACES</a>
                        <a class="dropdown-item" href="#">BRACELETS</a>
                    </div>
                </li>                
                <li class="nav-item"><a href="#" class="nav-link">Contacts</a></li>
            </ul>
        </div> -->


        <!-- Nút đăng ký -->
        <!-- <div class="navbar-right d-flex align-items-center">
            <button class="btn btn-dark">SIGN UP</button>
        </div> -->
            
        </div>
    </nav>
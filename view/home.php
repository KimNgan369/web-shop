<?php
    $html_bestsell = '';
    foreach ($bestsell as $sp) {
        extract($sp);  // Tạo các biến từ các trường trong mảng $sp
        
        // Kiểm tra nếu có hình ảnh, nếu không thì sử dụng ảnh mặc định
        $image_path = isset($image) ? 'layout/img/' . $image : 'layout/img/default.png'; 
        
        $html_bestsell .= '  <div class="col-md-4 mb-4">
                                <div class="card custom-card">
                                    <img src="' . $image_path . '" class="card-img-top" alt="' . htmlspecialchars($name) . '"> <!-- Hình ảnh sản phẩm -->
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">' . htmlspecialchars($name) . '</h5> <!-- Tên sản phẩm -->
                                        <p class="text-muted">Price: ' . htmlspecialchars($price) . '$</p> <!-- Giá sản phẩm -->
                                        <a href="#" class="text-decoration-none">Explore Now! →</a> <!-- Nút mua hàng -->
                                    </div>
                                </div>
                            </div>';        
    }

    $html_danhmucsp = '';
    foreach ($danhmucsp as $sp) {
        extract($sp);  // Tạo các biến từ các trường trong mảng $sp
        
        // Cập nhật mã HTML để hiển thị tên danh mục và hình ảnh động
        $html_danhmucsp .= '  <!-- ' . htmlspecialchars($name) . ' -->
            <div class="col-md-3 mb-4 text-center">
                <div class="category-card">
                    <a href="view/rings.php?type=' . urlencode($name) . '">
                        <img src="layout/img/' . $image . '" class="img-fluid" alt="' . htmlspecialchars($name) . '">
                    </a>
                </div>
                <p class="fw-bold">
                    <a href="view/rings.php?type=' . urlencode($name) . '" class="text-decoration-none text-dark">'
                        . htmlspecialchars($name) .
                    '</a>
                </p>
            </div>';
    
    }
    
?>



    <!-- Phan Thu Hut -->
    <section class="hero-section">
        <h1 style="color: rgb(255, 255, 255);">Welcome to the mythical store!</h1> <!-- Tieu de trang chu -->
        
        <!-- O tim kiem -->
        <div class="search-bar mt-3">
            <input type="text" class="form-control" placeholder="What are you looking for?"> <!-- O nhap noi dung tim kiem -->
            <button class="btn btn-warning"><i class="bi bi-search"></i></button> <!-- Nut tim kiem -->
        </div>
    </section>

<!-- Muc ban chay nhat -->
<section class="container my-5">
        <div class="row">
            <div class="col-md-3 d-flex flex-column justify-content-center">
                <h3 class="fw-bold">Best Selling Rings</h3> <!-- Tieu de danh muc -->
                <p><span class="text-muted"> The easiest way to exude charisma is to buy jewelry that you love.</p> <!-- Mo ta danh muc -->
                <button class="btn btn-warning">See more →</button> <!-- Nut xem them -->
            </div>
            <div class="col-md-9">
                <div class="row">

                    <?=$html_bestsell;?>
                    <!-- San pham Poseidon TRIDON -->
                    <!-- <div class="col-md-4 mb-4">
                        <div class="card custom-card">
                            <img src="layout/img/poseidon.png" class="card-img-top" alt="Poseidon TRIDON"> 
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Poseidon ‘TRIDON’</h5> 
                                <p class="text-muted">Price: 100$</p> 
                                <a href="#" class="text-decoration-none">Explore Now! →</a> 
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- San pham Zeus THUNDER -->
                    <!-- <div class="col-md-4 mb-4">
                        <div class="card custom-card">
                            <img src="layout/img/zeus.png" class="card-img-top" alt="Zeus THUNDER">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Zeus ‘THUNDER’</h5>
                                <p class="text-muted">Price: 100$</p>
                                <a href="#" class="text-decoration-none">Explore Now! →</a>
                            </div>
                        </div>
                    </div> -->
                    
                    <!-- San pham Hermes CADUCEUS -->
                    <!-- <div class="col-md-4 mb-4">
                        <div class="card custom-card">
                            <img src="layout/img/hermes.png" class="card-img-top" alt="Hermes CADUCEUS">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Hermes ‘CADUCEUS’</h5>
                                <p class="text-muted">Price: 100$</p>
                                <a href="#" class="text-decoration-none">Explore Now! →</a>
                            </div>
                        </div>
                    </div> -->

                </div>
            </div>
        </div>
    </section>

    <section class="container my-5">
        <div class="row">


            <!-- Cột tiêu đề và nút xem tất cả -->
            <div class="col-md-3 d-flex flex-column justify-content-center">
                <h3 class="fw-bold">Shop by</h3>
                <h3 class="fw-bold">Jewelry Type</h3>
                <button class="btn btn-warning w-50">View all →</button>
                <!-- <li><a href="?pg=shop">Shop</a></li> -->
            </div>
            

            <!-- Cột chứa danh mục trang sức -->
            <div class="col-md-9">
                <div class="row">
                    
                <?=$html_danhmucsp;?>
                <!-- Earrings -->
                    <!-- <div class="col-md-3 mb-4 text-center">
                        <div class="category-card">
                            <img src="layout/img/poseidon.png" class="img-fluid" alt="Earrings">
                        </div>
                        <p class="fw-bold">EARRINGS</p>
                    </div> -->
                    
                    <!-- Necklaces -->
                    <!-- <div class="col-md-3 mb-4 text-center">
                        <div class="category-card">
                            <img src="layout/img/hermes.png" class="img-fluid" alt="Necklaces">
                        </div>
                        <p class="fw-bold">NECKLACES</p>
                    </div> -->
                    
                    <!-- Bracelets -->
                    <!-- <div class="col-md-3 mb-4 text-center">
                        <div class="category-card">
                            <img src="layout/img/zeus.png" class="img-fluid" alt="Bracelets">
                        </div>
                        <p class="fw-bold">BRACELETS</p>
                    </div> -->
                    
                    <!-- Rings -->
                    <!-- <div class="col-md-3 mb-4 text-center">
                        <div class="category-card">
                            <img src="layout/img/zeus.png" class="img-fluid" alt="Rings">
                        </div>
                        <p class="fw-bold">RINGS</p>
                    </div> -->

                    
                </div>
            </div>
        </div>
    </section>

   

    <!-- Huong dan chon nhan -->
    <div class="container my-5"> <!-- Khoi chua phan huong dan chon nhan -->
        <div class="row g-0 rounded-4 overflow-hidden"> <!-- Bo tron goc va tranh tran noi dung -->

            <!-- Phan ben trai (chu + nen vang) -->
            <div class="col-md-6 p-4 d-flex flex-column justify-content-center" style="background-color: #EAD169;">
                <h3 class="fw-bold mb-3" style="font-size: 40px;">HAND CRAFTED FINE PIECES</h3> <!-- Tieu de -->
                <ul class="list-unstyled"> <!-- Danh sach nhan -->
                    <li class="ms-4"><span class="text-muted" style="font-size: 25px;">We also firmly believed that</span></li>
                    <li class="ms-4"><span class="text-muted"style="font-size: 25px;">our customers deserved more choices,</span></li>
                    <li class="ms-4"><span class="text-muted"style="font-size: 25px;">straightforward information</span></li>
                    <li class="ms-4"><span class="text-muted"style="font-size: 25px;">and legendary service.</span></li>
                </ul>
                <div class="mt-3">
                    <a href="#" class="btn btn-dark fw-bold">LEARN MORE</a> <!-- Nut xem chi tiet -->
                </div>
            </div>

            <!-- Phan ben phai (hinh anh) -->
            <div class="col-md-6">
                <img src="layout/img/makering.jpg" alt="Ring Crafting" class="img-fluid h-100 w-100 object-fit-cover">
            </div>

        </div>
    </div>
<?php
include_once "dao/products.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận các bộ lọc từ form POST
    $filtered_price = isset($_POST['price']) ? $_POST['price'] : [];
    $filtered_material = isset($_POST['material']) ? $_POST['material'] : [];
    $filtered_style = isset($_POST['style']) ? $_POST['style'] : [];

    // Lấy danh sách sản phẩm đã lọc
    $dssp = get_dssp(3, $filtered_price, $filtered_material, $filtered_style);

    // Xây dựng HTML cho các sản phẩm
    $html_dssp = '';
    foreach($dssp as $sp) {
        extract($sp);
        $html_dssp .= '<div class="product-card">
                            <img src="layout/img/'.$image.'" alt="">
                            <div class="product-info">
                                <h3>'.$name.'</h3>
                                <p class="price">PRICE: $'.$price.'</p>
                                <button class="explore-btn">Explore Now!</button>
                            </div>
                        </div>';
    }
} else {
    // Nếu không có form POST, chỉ lấy tất cả sản phẩm
    $dssp = get_dssp(10);
    $html_dssp = '';
    foreach($dssp as $sp) {
        extract($sp);
        $html_dssp .= '<div class="product-card">
                            <img src="layout/img/'.$image.'" alt="">
                            <div class="product-info">
                                <h3>'.$name.'</h3>
                                <p class="price">PRICE: $'.$price.'</p>
                                <button class="explore-btn">Explore Now!</button>
                            </div>
                        </div>';
    }
}

?>
    <main>
        <section class="page-title">
            <h1>Shop</h1>
            <div class="breadcrumb">
            </div>
        </section>


        <div class="content-wrapper">
            <aside class="filters">
            <h2>Filters</h2>

            <form method="POST">
                <div class="filter-group">
                    <h3>Prices</h3>
                    <div class="checkbox-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="price[]" value="0-50" checked>
                            <span class="checkmark"></span>
                            $0-$50
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="price[]" value="50-100">
                            <span class="checkmark"></span>
                            $50-$100
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="price[]" value="100-150">
                            <span class="checkmark"></span>
                            $100-$150
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="price[]" value="150-200">
                            <span class="checkmark"></span>
                            $150-$200
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="price[]" value="250-300">
                            <span class="checkmark"></span>
                            $250-$300
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="price[]" value="350-400">
                            <span class="checkmark"></span>
                            $350-$400
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Material</h3>
                    <div class="checkbox-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="material[]" value="Golden" checked>
                            <span class="checkmark"></span>
                            Golden
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="material[]" value="Silver">
                            <span class="checkmark"></span>
                            Silver
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="material[]" value="Titan">
                            <span class="checkmark"></span>
                            Titan
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="material[]" value="Diamond">
                            <span class="checkmark"></span>
                            Diamond
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h3>Style</h3>
                    <div class="checkbox-group">
                        <label class="checkbox-container">
                            <input type="checkbox" name="style[]" value="Bold" checked>
                            <span class="checkmark"></span>
                            Bold
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="style[]" value="Hidden">
                            <span class="checkmark"></span>
                            Hidden
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="style[]" value="Protection">
                            <span class="checkmark"></span>
                            Protection
                        </label>
                        <label class="checkbox-container">
                            <input type="checkbox" name="style[]" value="Themes">
                            <span class="checkmark"></span>
                            Themes
                        </label>
                    </div>
                </div>

                <button type="submit" class="filter-btn">FILTER NOW →</button>
            </form>
        </aside>

            <section class="products">
                <div class="products-grid">
                    <?php echo $html_dssp; ?>
                    <!-- Row 1 -->
                    <!-- <div class="product-card">
                        <img src="layout/img/poseidon.png" alt="Poseidon TRIDENT Ring">
                        <div class="product-info">
                            <h3>Poseidon "TRIDENT"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="layout/img/zeus.png" alt="Zeus THUNDER Ring">
                        <div class="product-info">
                            <h3>Zeus "THUNDER"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="layout/img/hades.png" alt="Zeus THUNDER Ring">
                        <div class="product-info">
                            <h3>Zeus "THUNDER"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                     -->
                    <!-- Row 2 -->
                    <!-- <div class="product-card">
                        <img src="layout/img/hermes.png" alt="Poseidon TRIDENT Ring">
                        <div class="product-info">
                            <h3>Poseidon "TRIDENT"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="layout/img/zeus.png" alt="Zeus THUNDER Ring">
                        <div class="product-info">
                            <h3>Zeus "THUNDER"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="layout/img/zeus.png" alt="Zeus THUNDER Ring">
                        <div class="product-info">
                            <h3>Zeus "THUNDER"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div> -->
                    
                    <!-- Row 3 -->
                    <!-- <div class="product-card">
                        <img src="layout/img/zeus.png" alt="Poseidon TRIDENT Ring">
                        <div class="product-info">
                            <h3>Poseidon "TRIDENT"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="layout/img/zeus.png" alt="Zeus THUNDER Ring">
                        <div class="product-info">
                            <h3>Zeus "THUNDER"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div>
                    
                    <div class="product-card">
                        <img src="layout/img/zeus.png" alt="Zeus THUNDER Ring">
                        <div class="product-info">
                            <h3>Zeus "THUNDER"</h3>
                            <p class="price">PRICE: $249</p>
                            <button class="explore-btn">Explore Now!</button>
                        </div>
                    </div> -->
                </div>
                
                <div class="pagination">
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                    <a href="#">›</a>
                </div>
            </section>
        </div>
    </main>


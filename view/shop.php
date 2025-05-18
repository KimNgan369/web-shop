<?php
include_once "dao/products.php";
include_once "dao/global.php";
$searchKeyword = $_GET['keyword'] ?? '';
$filtered_price = $_GET['price'] ?? [];
$filtered_material = $_GET['material'] ?? [];
$filtered_style = $_GET['style'] ?? [];

// Lấy danh sách sản phẩm đã lọc
$dssp = get_dssp(10, $filtered_price, $filtered_material, $filtered_style, $searchKeyword);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MYTH Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="layout/css/home.css">
    <link rel="stylesheet" href="layout/css/Rings.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body style="padding-top: 40px;">

<div class="container mt-4">
    <h2 class="text-center mt-5 mb-3" style="font-family: 'Poppins', serif; margin-top: 250px;">
        All Products
    </h2>
    <div class="breadcrumb">
        <a href="../web-shop/index.php">Home</a> > <span>Shop</span>
    </div>

    <div class="row">
        <!-- FILTER SECTION -->
        <div class="col-md-3">
            <form method="GET" action="?pg=shop" class="filter-section">
                <input type="hidden" name="pg" value="shop">
                
                <h5 style="font-family: 'Poppins'">Filters</h5>

                <!-- Search Box -->
                <div class="mb-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Search product..." value="<?= htmlspecialchars($searchKeyword) ?>">
                </div>

                <p><strong>Prices</strong></p>
                <?php
                $priceRanges = ['0-50', '50-100', '100-200', '200-500'];
                foreach ($priceRanges as $range) {
                    $checked = (isset($_GET['price']) && in_array($range, $_GET['price'])) ? 'checked' : '';
                    echo "<div class='form-check'><input type='checkbox' name='price[]' value='$range' class='form-check-input' $checked> \$$range</div>";
                }
                ?>

                <p><strong>Material</strong></p>
                <?php
                $materials = ['Silver', 'Golden', 'Titan', 'Diamond'];
                foreach ($materials as $material) {
                    $checked = (isset($_GET['material']) && in_array($material, $_GET['material'])) ? 'checked' : '';
                    echo "<div class='form-check'><input type='checkbox' name='material[]' value='$material' class='form-check-input' $checked> $material</div>";
                }
                ?>

                <p><strong>Style</strong></p>
                <?php
                $styles = ['Zeus', 'Hades', 'Poseidon', 'Hermes'];
                foreach ($styles as $style) {
                    $checked = (isset($_GET['style']) && in_array($style, $_GET['style'])) ? 'checked' : '';
                    echo "<div class='form-check'><input type='checkbox' name='style[]' value='$style' class='form-check-input' $checked> $style</div>";
                }
                ?>


            </form>
        </div>

        <!-- PRODUCT LIST -->
        <div class="col-md-9">
            <div class="row" id="product-list">
                <?php if (!empty($dssp)) { 
                    foreach ($dssp as $sp) {
                        extract($sp);
                        $img = IMG_PATH . htmlspecialchars($image);
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($name) ?>" style="height: 250px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                                    <p class="card-text text-muted">Price: $<?= htmlspecialchars($price) ?></p>
                                    <a href="../web-shop/view/ring_detail.php?id=<?= $id ?>" class="btn btn-warning w-100">View More</a>
                                </div>
                            </div>
                        </div>
                    <?php } 
                } else { ?>
                    <p>No products found matching your criteria.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/shop.js"></script>

<script>
    document.querySelectorAll('.filter-section input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            this.form.submit();
        });
    });

    document.querySelector('.filter-section input[name="keyword"]').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
</script>

</body>
</html>
<?php

include "../dao/products.php";

$type = $_GET['type'] ?? null;
$loai = $type;
$products = [];
$searchKeyword = $_GET['keyword'] ?? '';

if ($type) {
    $sql = "SELECT id FROM categories WHERE name = ?";
    $category = pdo_query_one($sql, $type);

    if ($category) {
        $category_id = $category['id'];

        $sql = "SELECT * FROM products WHERE category_id = ?";
        $params = [$category_id];

        // PRICE FILTER
        if (!empty($_GET['price'])) {
            $priceConditions = [];
            foreach ($_GET['price'] as $range) {
                [$min, $max] = explode('-', $range);
                $priceConditions[] = "(price >= ? AND price <= ?)";
                $params[] = $min;
                $params[] = $max;
            }
            $sql .= " AND (" . implode(" OR ", $priceConditions) . ")";
        }

        // MATERIAL FILTER
        if (!empty($_GET['material'])) {
            $placeholders = implode(',', array_fill(0, count($_GET['material']), '?'));
            $sql .= " AND material IN ($placeholders)";
            $params = array_merge($params, $_GET['material']);
        }

        // STYLE FILTER
        if (!empty($_GET['style'])) {
            $placeholders = implode(',', array_fill(0, count($_GET['style']), '?'));
            $sql .= " AND style IN ($placeholders)";
            $params = array_merge($params, $_GET['style']);
        }

        // SEARCH KEYWORD
        if (!empty($searchKeyword)) {
            $sql .= " AND name LIKE ?";
            $params[] = '%' . $searchKeyword . '%';
        }

        $products = pdo_query($sql, ...$params);
    }
}
?>
<?php include "header.php" ?>

<div style="height: 50px;"></div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MYTH Rings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../layout/css/home.css">
    <link rel="stylesheet" href="../layout/css/Rings.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .filter-section button {
            display: none;
        }
    </style>
</head>


<div class="container mt-4">
    <h2 class="text-center mt-5 mb-3" style="font-family: 'Poppins', serif; margin-top: 400px;">
        <?= htmlspecialchars($loai) ?>
    </h2>
    <div class="breadcrumb">
        <a href="../index.php?pg=shop">Shop</a> > <span><?= htmlspecialchars($loai) ?></span>
    </div>

    <div class="row">
        <!-- FILTER SECTION -->
        <div class="col-md-3">
            <form method="get" action="rings.php" class="filter-section">
                <input type="hidden" name="type" value="<?= htmlspecialchars($type) ?>">

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

                <button type="submit" class="btn btn-warning mt-3">Filter now</button>
            </form>
        </div>

        <!-- PRODUCT LIST -->
        <div class="col-md-9">
            <div class="row" id="product-list">
                <?php if (!empty($products)) {
                    foreach ($products as $sp) {
                        extract($sp);
                        $img = '../layout/img/' . $image;
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="<?= $img ?>" class="card-img-top" alt="<?= htmlspecialchars($name) ?>" style="height: 250px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($name) ?></h5>
                                    <p class="card-text text-muted">Price: $<?= htmlspecialchars($price) ?></p>
                                    <a href="ring_detail.php?id=<?= $id ?>" class="btn btn-warning w-100">View More</a>
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
<script src="../js/Rings.js"></script>


<!-- Script tự động submit form khi chọn filter -->
<script>
    document.querySelectorAll('.filter-section input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            this.form.submit();
        });
    });

    // Tự động submit form khi search
    document.querySelector('.filter-section input[name="keyword"]').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
</script>

<?php include "footer1.php" ?>

</body>
</html>

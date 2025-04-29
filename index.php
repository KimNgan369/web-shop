<?php
// Nhúng kết nối CSDL
include "dao/pdo.php";
include "dao/products.php";

include "view/header.php";

// Data cho trang chủ 
$bestsell = get_bestselling(3);
$danhmucsp = get_danhmucsp();

if (!isset($_GET['pg'])) {
    include "view/home.php";
} else {
    switch ($_GET['pg']) {
        case 'shop':
            $dssp = get_dssp(6);
            include "view/shop.php";
            break;
        case 'gioithieu':
            include "view/gioithieu.php";
            break;


        case 'rings':
            $dssp=get_dssp(6);
            $spchitiet='';
            $splienquan='';
            include "view/rings.php";
            break;


        case 'rings':
            $dssp = get_dssp(6);
            $spchitiet = '';
            $splienquan = '';
            include "view/rings.php";
            break;
        case 'ring_detail':
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $id = $_GET['id'];
                $spchitiet = get_product_by_id($id); // Bạn cần viết hàm get_product_by_id() trong dao/products.php
                $splienquan = get_products_lienquan($id); // nếu muốn lấy thêm sản phẩm liên quan
                include "view/ring_detail.php";
            } else {
                echo "<h2 class='text-center my-5'>Không tìm thấy sản phẩm.</h2>";
            }
            break;

        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>


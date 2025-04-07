<?php
//Nhúng kết nối CSDL
include "dao/pdo.php";
include "dao/products.php";

include "view/header.php";

//data cho trang chu 
$bestsell=get_bestselling(3);
$danhmucsp=get_danhmucsp();


if (!isset($_GET['pg'])) {
    include "view/home.php";
} else {
    switch ($_GET['pg']) {
        case 'shop':
            include "view/shop.php";
            break;
        case 'gioithieu':
            include "view/gioithieu.php";
            break;
        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>

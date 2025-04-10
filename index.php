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
            $dssp=get_dssp(6);
            include "view/shop.php";
            break;
        case 'gioithieu':
            include "view/gioithieu.php";
            break;
<<<<<<< HEAD
            case 'rings':
                $dssp=get_dssp(6);
                $spchitiet='';
                $splienquan='';
                include "view/rings.php";
                break;
=======
>>>>>>> 5aaec78ab1a184ec675d04bd478700e6e7834a55
        default:
            include "view/home.php";
            break;
    }
}

include "view/footer.php";
?>
<<<<<<< HEAD
=======

>>>>>>> 5aaec78ab1a184ec675d04bd478700e6e7834a55

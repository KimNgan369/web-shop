<?php
session_start();
ob_start();

if (isset($_SESSION["role"]) && ($_SESSION["role"] == 1)) {
    
//Nhúng kết nối CSDL
include "models/pdo.php";
include "models/products.php";

include "view/header.php";


if (!isset($_GET['act'])) {
    include "view/home.php";
} else {
    switch ($_GET['act']) {

        case 'logout':
            if(isset($_SESSION['role'])) {
                unset($_SESSION['role']);
            }
            header('location: login.php');
            exit; // Thêm exit sau khi chuyển hướng để đảm bảo dừng việc thực thi mã
            break;

        default:
            include "view/home.php";
            break;
    }
}
include "view/footer.php";
} else {
    header('location: login.php');
}
?>


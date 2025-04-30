<?php
session_start();
// Nhúng kết nối CSDL
include "dao/pdo.php";
include "dao/products.php";
include "dao/user.php";

// Data chung cho các trang
$bestsell = get_bestselling(3);
$danhmucsp = get_danhmucsp();

if (!isset($_GET['pg'])) {
    include "view/header.php";
    include "view/home.php";
    include "view/footer.php";
} else {
    switch ($_GET['pg']) {
        case 'home':
            $dssp = get_dssp(6);
            include "view/header.php";
            include "view/home.php";
            include "view/footer.php";
            break;

        case 'shop':
            $dssp = get_dssp(6);
            include "view/header.php";
            include "view/shop.php";
            include "view/footer.php";
            break;

        case 'signup':
            // Không include header/footer
            include "view/sign_up.php";
            break;

        case 'gioithieu':
            include "view/header.php";
            include "view/gioithieu.php";
            include "view/footer.php";
            break;

        // case 'rings':
        //     $dssp=get_dssp(6);
        //     $spchitiet='';
        //     $splienquan='';
        //     include "view/rings.php";
        //     break;


        case 'rings':
            $dssp = get_dssp(6);
            $spchitiet = '';
            $splienquan = '';
            include "view/header.php";
            include "view/rings.php";
            include "view/footer.php";
            break;

        case 'ring_detail':
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $id = $_GET['id'];
                $spchitiet = get_product_by_id($id);
                $splienquan = get_products_lienquan($id);
                include "view/header.php";
                include "view/ring_detail.php";
                include "view/footer.php";
            } else {
                include "view/header.php";
                echo "<h2 class='text-center my-5'>Không tìm thấy sản phẩm.</h2>";
                include "view/footer.php";
            }
            break;

        
        case 'adduser':
            if (isset($_POST["signup"]) && ($_POST["signup"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
        
                // Kiểm tra username
                if (user_exist($username)) {
                    $error = "Tên đăng nhập '$username' đã tồn tại. Vui lòng chọn tên khác.";
                    include "view/sign_up.php";
                }
                // Kiểm tra email
                elseif (email_exist($email)) {
                    $error = "Email '$email' đã được sử dụng. Vui lòng dùng email khác.";
                    include "view/sign_up.php";
                } else {
                    user_insert($username, $password, $email);
                    include "view/login.php";
                }
            }
            break;
        
        case 'login':
            // input
            if (isset($_POST["login"]) && ($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                
                // xl: kiem tra
                $kq = checkuser($email, $password);
        
                if (is_array($kq) && count($kq)) {
                    $_SESSION['s_user'] = $kq;
                    unset($_SESSION['tb_dangnhap']); // Xóa thông báo lỗi nếu đăng nhập thành công
                    header('location: index.php');
                } else {
                    $tb = "Email hoặc mật khẩu không đúng!";
                    $_SESSION['tb_dangnhap'] = $tb;
                    header('location: index.php?pg=dangnhap');
                }
            }
            break;
        
        case 'dangnhap':
            include "view/login.php";
            break;
        
        case 'logout':
            if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                unset($_SESSION['s_user']);
            }
            header('location: index.php');
            break;
    
        case 'myacc':
            if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                include "view/myacc.php";
            }
            break;
            

        default:
            include "view/header.php";
            include "view/home.php";
            include "view/footer.php";
            break;
    }
}
?>


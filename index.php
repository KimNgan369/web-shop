<?php
session_start();
// Nhúng kết nối CSDL
include "dao/pdo.php";
include "dao/products.php";
include "dao/user.php";
include "view/header.php";

// Data cho trang chủ 

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


        case 'rings':
            $dssp=get_dssp(6);
            $spchitiet='';
            $splienquan='';
            include "view/rings.php";
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
           
            include "view/ring_detail.php";
            break;
        
        case 'shoppingcart':
            session_start();
            
            if (isset($_POST['addToCart'])) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }
                
                $product_id = (int)$_POST['id'];
                
                
                if (isset($_SESSION['cart'][$product_id])) {
                    $_SESSION['cart'][$product_id]['quantity'] += (int)$_POST['quantity'];
                } else {
                    $_SESSION['cart'][$product_id] = [
                        'id' => $product_id,
                        'name' => $_POST['name'],
                        'price' => (float)$_POST['price'],
                        'quantity' => (int)$_POST['quantity'],
                        'image' => $_POST['image']
                    ];
                }
                
                
                // Chuyển hướng để tránh submit lại
                header("Location: <?= $base_url ?>/shoppingcart.php");
                exit();
            }
            
            include "view/shoppingcart.php";
            break;


        case 'adduser':
            if (isset($_POST["signup"]) && ($_POST["signup"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
        
                if (user_exist($username)) {
                    $error = "Tên đăng nhập '$username' đã tồn tại. Vui lòng chọn tên khác.";
                    include "view/sign_up.php";
                }
                elseif (email_exist($email)) {
                    $error = "Email '$email' đã được sử dụng. Vui lòng dùng email khác.";
                    include "view/sign_up.php";
                } else {
                    user_insert($username, $password, $email);
                    include "view/login.php";
                }
            }
            break;
        
        case 'updateuser':
            if (isset($_POST["update"]) && ($_POST["update"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $address = $_POST["address"];
                $phone = $_POST["phone"];
                $id = $_POST["id"];
                $role = 0;
                user_update($username, $password, $email, $address, $phone, $role, $id);
                include "view/myacc_confirm.php";
            }
            break;
            
        case 'login':
            if (isset($_POST["login"]) && ($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                
                $kq = checkuser($email, $password);
        
                if (is_array($kq) && count($kq)) {
                    $_SESSION['s_user'] = $kq;
                    unset($_SESSION['tb_dangnhap']); 
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
            } else {
                header('location: index.php?pg=dangnhap');
            }
            break;
            
        case 'changepassword_form':
            if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                include "view/change_password.php";
            } else {
                header('location: index.php?pg=dangnhap');
            }
            break;
            
        case 'changepassword':
            if (isset($_POST["change_password"]) && ($_POST["change_password"])) {
                $current_password = $_POST["current_password"];
                $new_password = $_POST["new_password"];
                $confirm_password = $_POST["confirm_password"];
                $user_id = $_POST["id"];
                
                if (!verify_current_password($user_id, $current_password)) {
                    $_SESSION['password_error'] = "Mật khẩu hiện tại không đúng";
                    header('location: index.php?pg=changepassword_form');
                    exit();
                }
                
                if ($new_password !== $confirm_password) {
                    $_SESSION['password_error'] = "Mật khẩu mới và xác nhận mật khẩu không khớp";
                    header('location: index.php?pg=changepassword_form');
                    exit();
                }
                
                user_change_password($user_id, $new_password);
                
                $_SESSION['s_user']['password'] = $new_password;
                
                include "view/password_changed.php";
            }
            break;
            
        case 'updateinfo':
            if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                include "view/updateinfo.php";
            } else {
                header('location: index.php?pg=dangnhap');
            }
            break;

        case 'checkout':
            include "view/checkout.php";
            break;

        case 'ordercomplete':
            include "view/ordercomplete.php";
            break;

            
        default:
            include "view/header.php";
            include "view/home.php";
            include "view/footer.php";
            break;
}
}
?>
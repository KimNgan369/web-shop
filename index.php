<?php
session_start();
// Nhúng kết nối CSDL
include_once "dao/pdo.php";
include_once "dao/products.php";
include_once "dao/user.php";

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
            include "view/sign_up.php";
            break;

        case 'gioithieu':
            include "view/header.php";
            include "view/gioithieu.php";
            include "view/footer.php";
            break;
        
        case 'contacts':
            include "view/header.php";
            include "view/contact.php";
            include "view/footer.php";
            break;

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
                echo "<h2 class='text-center my-5'>Product not found.</h2>";
                include "view/footer.php";
            }
            break;

        case 'adduser':
            if (isset($_POST["signup"]) && ($_POST["signup"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
        
                if (user_exist($username)) {
                    $error = "Username '$username' already exists. Please choose another.";
                    include "view/sign_up.php";
                } elseif (email_exist($email)) {
                    $error = "Email '$email' is already in use. Please use another email.";
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
                $_SESSION['s_user'] = [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'role' => $role
                ];
                include "view/myacc_confirm.php";
            }
            break;
            
        case 'login':
            if (isset($_POST["login"]) && ($_POST["login"])) {
                $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                $password = $_POST["password"];
                
                $kq = checkuser($email, $password);
        
                if (is_array($kq) && count($kq)) {
                    $_SESSION['s_user'] = $kq;
                    $_SESSION['user_id'] = $kq['id']; // Lưu user_id để checkout.php sử dụng
                    unset($_SESSION['tb_dangnhap']);
                    header('Location: index.php');
                    exit();
                } else {
                    $_SESSION['tb_dangnhap'] = "Invalid email or password!";
                    header('Location: index.php?pg=dangnhap');
                    exit();
                }
            }
            include "view/login.php";
            break;
        
        case 'dangnhap':
            include "view/login.php";
            break;
        
        case 'logout':
            unset($_SESSION['s_user']);
            unset($_SESSION['user_id']);
            header('Location: index.php');
            exit();
            break;
    
        case 'myacc':
            if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                include "view/myacc.php";
            } else {
                header('Location: index.php?pg=dangnhap');
                exit();
            }
            break;
            
        case 'changepassword_form':
            if (isset($_SESSION['s_user']) && (count($_SESSION['s_user']) > 0)) {
                include "view/changepassword_form.php";
            } else {
                header('Location: index.php?pg=dangnhap');
                exit();
            }
            break;
            
        case 'changepassword':
            if (isset($_POST["change_password"]) && ($_POST["change_password"])) {
                $current_password = $_POST["current_password"];
                $new_password = $_POST["new_password"];
                $confirm_password = $_POST["confirm_password"];
                $user_id = $_POST["id"];
                
                if (!verify_current_password($user_id, $current_password)) {
                    $_SESSION['password_error'] = "Current password is incorrect";
                    header('Location: index.php?pg=changepassword_form');
                    exit();
                }
                
                if ($new_password !== $confirm_password) {
                    $_SESSION['password_error'] = "New password and confirm password do not match";
                    header('Location: index.php?pg=changepassword_form');
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
                header('Location: index.php?pg=dangnhap');
                exit();
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
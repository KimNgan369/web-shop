<?php
session_start();
ob_start();

// Include necessary files
include "../dao/global.php";
include "../dao/pdo.php";
include "../dao/products.php";
include "../dao/user.php"; // Include user DAO

// Check if user is admin
if (isset($_SESSION["role"]) && $_SESSION["role"] == 'admin') {
    include "view/header.php";

    $act = $_GET['act'] ?? '';
    switch ($act) {
        case 'logout':
            session_unset();
            session_destroy();
            header('Location: login.php');
            exit();

        case 'manage_user':
            $userlist = get_all_users();
            include "view/manage_user.php";
            break;

        case 'useradd':
            include "view/useradd.php";
            break;

        case 'adduser':
            if (isset($_POST['adduser'])) {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
                $address = $_POST['address'] ?? ''; // Allow HTML from CKEditor
                $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
                $is_vip = filter_input(INPUT_POST, 'is_vip', FILTER_VALIDATE_INT);

                if ($username && $password && $email && in_array($role, ['user', 'admin']) && in_array($is_vip, [0, 1])) {
                    if (user_exist($username)) {
                        echo "<p style='color:red'>Tên đăng nhập đã tồn tại!</p>";
                    } elseif (email_exist($email)) {
                        echo "<p style='color:red'>Email đã tồn tại!</p>";
                    } else {
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                        user_insert($username, $hashed_password, $email, $full_name, $phone, $address, $role, $is_vip);
                        header('Location: index.php?act=manage_user');
                        exit();
                    }
                } else {
                    echo "<p style='color:red'>Vui lòng điền đầy đủ thông tin hợp lệ.</p>";
                }
            }
            include "view/useradd.php";
            break;

        case 'deluser':
            if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $id = $_GET['id'];
                try {
                    user_delete($id);
                } catch (Exception $e) {
                    echo "<h3 style='color:red; text-align:center'>Không thể xóa người dùng này!</h3>";
                }
                header('Location: index.php?act=manage_user');
                exit();
            }
            $userlist = get_all_users();
            include "view/manage_user.php";
            break;

        case 'updateuser':
            if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $id = $_GET['id'];
                $user = get_user($id);
                include "view/updateuser.php";
            } elseif (isset($_POST['updateuser'])) {
                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                $full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
                $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
                $address = $_POST['address'] ?? ''; // Allow HTML from CKEditor
                $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
                $is_vip = filter_input(INPUT_POST, 'is_vip', FILTER_VALIDATE_INT);

                if ($id && $username && $email && in_array($role, ['user', 'admin']) && in_array($is_vip, [0, 1])) {
                    $existing_user = get_user($id);
                    if ($existing_user['username'] !== $username && user_exist($username)) {
                        echo "<p style='color:red'>Tên đăng nhập đã tồn tại!</p>";
                    } elseif ($existing_user['email'] !== $email && email_exist($email)) {
                        echo "<p style='color:red'>Email đã tồn tại!</p>";
                    } else {
                        if ($password) {
                            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                            user_update_with_password($username, $hashed_password, $email, $full_name, $phone, $address, $role, $is_vip, $id);
                        } else {
                            user_update($username, $email, $full_name, $phone, $address, $role, $is_vip, $id);
                        }
                        header('Location: index.php?act=manage_user');
                        exit();
                    }
                } else {
                    echo "<p style='color:red'>Vui lòng điền đầy đủ thông tin hợp lệ.</p>";
                }
            }
            break;

        case 'sanphamlist':
            $sanphamlist = get_spadmin();
            include "view/sanphamlist.php";
            break;

        case 'sanphamadd':
            $danhmuclist = get_danhmucadmin();
            include "view/sanphamadd.php";
            break;

        case 'addproduct':
            if (isset($_POST['addproduct'])) {
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
                $category_id = filter_input(INPUT_POST, 'danhmuc', FILTER_VALIDATE_INT);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                $material = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING);
                $style = filter_input(INPUT_POST, 'style', FILTER_SANITIZE_STRING);

                $image = '';
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= 2 * 1024 * 1024) {
                        $image = uniqid() . '_' . basename($_FILES['image']['name']);
                        $target_file = IMG_PATH_ADMIN . $image;
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                    }
                }

                if ($name && $price !== false && $category_id && $description && $material && $style) {
                    sanpham_insert($name, $price, $category_id, $description, $material, $style, $image);
                    header('Location: index.php?act=sanphamlist');
                    exit();
                }
            }
            $danhmuclist = get_danhmucadmin();
            include "view/sanphamadd.php";
            break;

        case 'delproduct':
            if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $id = $_GET['id'];
                $image = IMG_PATH_ADMIN . get_img($id);
                if (is_file($image)) {
                    unlink($image);
                }
                try {
                    sanpham_delete($id);
                } catch (Exception $e) {
                    echo "<h3 style='color:red; text-align:center'>Sản phẩm đã có trong giỏ hàng! Không được quyền xóa!</h3>";
                }
                header('Location: index.php?act=sanphamlist');
                exit();
            }
            $sanphamlist = get_spadmin();
            include "view/sanphamlist.php";
            break;

        case 'updateproduct':
            if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
                $id = $_GET['id'];
                $sp = get_sp_by_id($id);
                $danhmuclist = get_danhmucadmin();
                include "view/updateproduct.php";
            }
            break;

        case 'addproducts':
            if (isset($_POST['addproducts'])) {
                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
                $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
                $category_id = filter_input(INPUT_POST, 'danhmuc', FILTER_VALIDATE_INT);
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
                $material = filter_input(INPUT_POST, 'material', FILTER_SANITIZE_STRING);
                $style = filter_input(INPUT_POST, 'style', FILTER_SANITIZE_STRING);

                $current_product = get_sp_by_id($id);
                $image = $current_product['image'];

                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($_FILES['image']['type'], $allowed_types) && $_FILES['image']['size'] <= 2 * 1024 * 1024) {
                        if (!empty($current_product['image'])) {
                            $old_image_path = IMG_PATH_ADMIN . $current_product['image'];
                            if (file_exists($old_image_path)) {
                                unlink($old_image_path);
                            }
                        }
                        $image = uniqid() . '_' . basename($_FILES['image']['name']);
                        $target_file = IMG_PATH_ADMIN . $image;
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                    }
                }

                if ($id && $name && $price !== false && $category_id && $description && $material && $style) {
                    sanpham_update($name, $price, $category_id, $description, $material, $style, $image, $id);
                    header('Location: index.php?act=sanphamlist');
                    exit();
                }
            }
            break;

        default:
            include "view/home.php";
            break;
    }
    include "view/footer.php";
} else {
    header('Location: login.php');
    exit();
}

ob_end_flush();
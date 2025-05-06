<?php
session_start();
ob_start();

// Include necessary files
include "../dao/global.php";
include "../dao/pdo.php";
include "../dao/products.php";

// Check if user is admin
if (isset($_SESSION["role"]) && ($_SESSION["role"] == 'admin')) {
    include "view/header.php";

    if (!isset($_GET['act'])) {
        include "view/home.php";
    } else {
        switch ($_GET['act']) {
            case 'logout':
                // Clear session variables
                unset($_SESSION['role']);
                unset($_SESSION['s_user']);
                session_destroy();
                header('location: login.php');
                exit();
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
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $category_id = $_POST['danhmuc'];
                    $description = $_POST['description'];
                    $material = $_POST['material'];
                    $style = $_POST['style'];
                    
                    $image = '';
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $image = $_FILES['image']['name'];
                        $target_file = IMG_PATH_ADMIN . $image;
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                    }

                    sanpham_insert($name, $price, $category_id, $description, $material, $style, $image);
                    header('Location: index.php?act=sanphamlist');
                    exit();
                } else {
                    $danhmuclist = get_danhmucadmin();
                    include "view/sanphamadd.php";
                }
                break;
                
            case 'delproduct':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $id = $_GET['id'];
                    $image = IMG_PATH_ADMIN . get_img($id);
                    if (is_file($image)) {
                        unlink($image);
                    }
                    try {
                        sanpham_delete($id);
                    } catch (\Throwable $th) {
                        echo "<h3 style='color:red; text-align:center'>Sản phẩm đã có trong giỏ hàng! Không được quyền xóa!</h3>";
                    }
                }
                $sanphamlist = get_spadmin();
                include "view/sanphamlist.php";
                break;
                
            case 'updateproduct':
                if (isset($_GET['id']) && ($_GET['id'] > 0)) {
                    $id = $_GET['id'];
                    $sp = get_sp_by_id($id);
                }
                $danhmuclist = get_danhmucadmin();
                include "view/updateproduct.php";
                break;
                
            case 'addproducts':
                if (isset($_POST['addproducts'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $category_id = $_POST['danhmuc'];
                    $description = $_POST['description'];
                    $material = $_POST['material'];
                    $style = $_POST['style'];
                    
                    $current_product = get_sp_by_id($id);
                    $image = $current_product['image'];
                    
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        if (!empty($current_product['image'])) {
                            $old_image_path = IMG_PATH_ADMIN . $current_product['image'];
                            if (file_exists($old_image_path)) {
                                unlink($old_image_path);
                            }
                        }
                        $image = $_FILES['image']['name'];
                        $target_file = IMG_PATH_ADMIN . $image;
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                    }
                    
                    sanpham_update($name, $price, $category_id, $description, $material, $style, $image, $id);
                    header('Location: index.php?act=sanphamlist');
                    exit();
                }
                break;
                
            default:
                include "view/home.php";
                break;
        }
    }
    include "view/footer.php";
} else {
    header('location: login.php');
    exit;
}

ob_end_flush();
?>
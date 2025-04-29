<?php
session_start();
ob_start();

// if (isset($_SESSION["role"]) && ($_SESSION["role"] == 1)) {
    
//Nhúng kết nối CSDL
include "../dao/global.php";
include "../dao/pdo.php";
include "../dao/products.php";

include "view/header.php";


if (!isset($_GET['act'])) {
    include "view/home.php";
} else {
    switch ($_GET['act']) {
        
        // case 'logout':
        //     if(isset($_SESSION['role'])) {
        //         unset($_SESSION['role']);
        //     }
        //     header('location: login.php');
        //     exit; // Thêm exit sau khi chuyển hướng để đảm bảo dừng việc thực thi mã
        //     break;
        case 'sanphamlist':
            $sanphamlist=get_spadmin();
            include "view/sanphamlist.php";
            break;
        case 'sanphamadd':
            $danhmuclist=get_danhmucadmin();
            include "view/sanphamadd.php";
            break;
            case 'addproduct':
                if(isset($_POST['addproduct'])) {
                    // lấy dữ liệu về
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $category_id = $_POST['danhmuc'];
                    $description = $_POST['description'];
                    $material = $_POST['material'];
                    $style = $_POST['style'];
                    
                    $image=$_FILES['image']['name'];

                    sanpham_insert($name, $price, $category_id, $description, $material, $style, $image);

                    $target_file = IMG_PATH_ADMIN.$image;
                    move_uploaded_file($_FILES['image']['name'], $target_file);
                    
                    
                    $sanphamlist = get_spadmin();
                    include "view/sanphamlist.php";
                } else {
                    $danhmuclist = get_danhmucadmin();
                    include "view/sanphamadd.php";
                }
                break;
        case 'delproduct' :
            if(isset($_GET['id']) &&($_GET['id']>0)){
                $id = $_GET['id'];
                $image = IMG_PATH_ADMIN.get_img($id);
                if(is_file($image)) {
                    unlink($image);
                }
                try {
                    sanpham_delete($id);
                } catch (\Throwable $th) {
                    echo "<h3 style='color:red ; text-align:center'>Sản phẩm đã có trong giỏ hàng!Không được quyền xóa!</h3>";
                }
                
            }
            $sanphamlist = get_spadmin();
            include "view/sanphamlist.php";
            break;
        case 'updateproduct' :
            if(isset($_GET['id']) &&($_GET['id']>0)) {
                $id = $_GET['id'];
                $sp = get_sp_by_id($id);
            }
            $danhmuclist=get_danhmucadmin();
            include "view/updateproduct.php";
            break;
            case 'addproducts':
                if(isset($_POST['addproducts'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $price = $_POST['price'];
                    $category_id = $_POST['danhmuc'];
                    $description = $_POST['description'];
                    $material = $_POST['material'];
                    $style = $_POST['style'];
                    
                    // Xử lý ảnh upload
                    $current_product = get_sp_by_id($id);
                    $image = $current_product['image']; // Giữ ảnh cũ mặc định
                    
                    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        // Xóa ảnh cũ nếu có
                        if(!empty($current_product['image'])) {
                            $old_image_path = IMG_PATH_ADMIN.$current_product['image'];
                            if(file_exists($old_image_path)) {
                                unlink($old_image_path);
                            }
                        }
                        
                        // Upload ảnh mới
                        $image = $_FILES['image']['name'];
                        $target_file = IMG_PATH_ADMIN.$image;
                        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
                    }
                    
                    // Cập nhật sản phẩm
                    sanpham_update($name, $price, $category_id, $description, $material, $style, $image, $id);
                    
                    // Chuyển hướng về trang danh sách
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
// } else {
//     // header('location: login.php');
// }
?>


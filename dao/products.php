<?php
require_once 'pdo.php';

function sanpham_insert($name, $price, $category_id, $description, $material, $style, $image){
    $sql = "INSERT INTO products(name, price, category_id, description, material, style, image) VALUES (?,?,?,?,?,?,?)";
    pdo_execute($sql, $name, $price, $category_id, $description, $material, $style, $image);
}

function sanpham_update($name, $price, $category_id, $description, $material, $style, $image, $id){
    if($image!="") {
        $sql = "UPDATE products SET name=?,price=?,category_id=?,description=?,material=?,style=?,image=? where id=?";
    pdo_execute($sql, $name, $price, $category_id, $description, $material, $style, $image, $id);
    } else {
        $sql = "UPDATE products SET name=?,price=?,category_id=?,description=?,material=?,style=? where id=?";
    pdo_execute($sql, $name, $price, $category_id, $description, $material, $style, $id);
    }
    
}

function sanpham_delete($id){
     $sql = "DELETE FROM products WHERE  id=?";
    // if(is_array($ma_hh)){
    //     foreach ($ma_hh as $ma) {
    //         pdo_execute($sql, $ma);
    //     }
    // }
    // else{
         pdo_execute($sql, $id);
    // }
}

function get_img($id) {
    $sql = "SELECT * FROM products WHERE id=?";
    $getimg = pdo_query_one($sql,$id);
    return $getimg['image'];
}

function get_danhmucsp() {
    $sql = "SELECT * FROM categories";  // Truy vấn lấy các danh mục
    return pdo_query($sql);  // Trả về kết quả từ truy vấn
    //hihihihihi dung ne
}



function get_bestselling($limi) {
    // Truy vấn sản phẩm bán chạy dựa trên tổng số lượng bán ra
    $sql = "SELECT p.id, p.name, p.price, p.image, SUM(oi.quantity) AS total_sold
            FROM products p
            JOIN order_items oi ON p.id = oi.product_id
            JOIN orders o ON oi.order_id = o.id
            WHERE o.status = 'Delivered'  -- Chỉ tính các đơn hàng đã giao
            GROUP BY p.id
            ORDER BY total_sold DESC
            LIMIT " . $limi;
    
    return pdo_query($sql);
}

function get_dssp($limi, $filtered_price = [], $filtered_material = [], $filtered_style = []) {
    $sql = "SELECT * FROM products WHERE 1"; 

    // Lọc theo giá
    if (!empty($filtered_price)) {
        $price_conditions = [];
        foreach ($filtered_price as $price) {
            list($min, $max) = explode('-', $price);
            $price_conditions[] = "price BETWEEN $min AND $max";
        }
        $sql .= " AND (" . implode(" OR ", $price_conditions) . ")";
    }

        // Lọc theo vật liệu (đã thay đổi giá trị)
        if (!empty($filtered_material)) {
            $sql .= " AND material IN ('" . implode("','", $filtered_material) . "')";
        }

        // Lọc theo phong cách (đã thay đổi giá trị)
        if (!empty($filtered_style)) {
            $sql .= " AND style IN ('" . implode("','", $filtered_style) . "')";
        }

        $sql .= " ORDER BY id DESC LIMIT " . $limi;
        return pdo_query($sql);
}


function get_products_by_category_id($category_id) {
    $sql = "SELECT * FROM products WHERE category_id = ?";
    return pdo_query($sql, $category_id);
}
function get_products_filtered_by_category($category_id, $price_arr, $material_arr, $style_arr) {
    $sql = "SELECT * FROM products WHERE category_id = ?";
    $params = [$category_id];

    // Filter theo price
    if (!empty($price_arr)) {
        $price_conditions = [];
        foreach ($price_arr as $range) {
            [$min, $max] = explode('-', $range);
            $price_conditions[] = "(price BETWEEN ? AND ?)";
            $params[] = $min;
            $params[] = $max;
        }
        $sql .= " AND (" . implode(" OR ", $price_conditions) . ")";
    }

    // Filter theo material
    if (!empty($material_arr)) {
        $placeholders = implode(',', array_fill(0, count($material_arr), '?'));
        $sql .= " AND material IN ($placeholders)";
        $params = array_merge($params, $material_arr);
    }

    // Filter theo style
    if (!empty($style_arr)) {
        $placeholders = implode(',', array_fill(0, count($style_arr), '?'));
        $sql .= " AND style IN ($placeholders)";
        $params = array_merge($params, $style_arr);
    }

    return pdo_query($sql, ...$params);
}





function get_sp_by_id($id){
    $sql = "SELECT * FROM products WHERE id=?";
    return pdo_query_one($sql, $id);
} 


//admin
function get_spadmin() {
    $sql = "SELECT products.*, categories.name as category_name 
            FROM products 
            JOIN categories ON products.category_id = categories.id
            ORDER BY products.id ASC";  
    return pdo_query($sql);  
}

function get_danhmucadmin() {
    $sql = "SELECT * FROM categories";  // Truy vấn lấy các danh mục
    return pdo_query($sql);
}



// function hang_hoa_select_by_id($ma_hh){
//     $sql = "SELECT * FROM hang_hoa WHERE ma_hh=?";
//     return pdo_query_one($sql, $ma_hh);
// }



// function hang_hoa_exist($ma_hh){
//     $sql = "SELECT count(*) FROM hang_hoa WHERE ma_hh=?";
//     return pdo_query_value($sql, $ma_hh) > 0;
// }

// function hang_hoa_tang_so_luot_xem($ma_hh){
//     $sql = "UPDATE hang_hoa SET so_luot_xem = so_luot_xem + 1 WHERE ma_hh=?";
//     pdo_execute($sql, $ma_hh);
// }

// function hang_hoa_select_top10(){
//     $sql = "SELECT * FROM hang_hoa WHERE so_luot_xem > 0 ORDER BY so_luot_xem DESC LIMIT 0, 10";
//     return pdo_query($sql);
// }

// function hang_hoa_select_dac_biet(){
//     $sql = "SELECT * FROM hang_hoa WHERE dac_biet=1";
//     return pdo_query($sql);
// }

// function hang_hoa_select_by_loai($ma_loai){
//     $sql = "SELECT * FROM hang_hoa WHERE ma_loai=?";
//     return pdo_query($sql, $ma_loai);
// }

// function hang_hoa_select_keyword($keyword){
//     $sql = "SELECT * FROM hang_hoa hh "
//             . " JOIN loai lo ON lo.ma_loai=hh.ma_loai "
//             . " WHERE ten_hh LIKE ? OR ten_loai LIKE ?";
//     return pdo_query($sql, '%'.$keyword.'%', '%'.$keyword.'%');
// }

// function hang_hoa_select_page(){
//     if(!isset($_SESSION['page_no'])){
//         $_SESSION['page_no'] = 0;
//     }
//     if(!isset($_SESSION['page_count'])){
//         $row_count = pdo_query_value("SELECT count(*) FROM hang_hoa");
//         $_SESSION['page_count'] = ceil($row_count/10.0);
//     }
//     if(exist_param("page_no")){
//         $_SESSION['page_no'] = $_REQUEST['page_no'];
//     }
//     if($_SESSION['page_no'] < 0){
//         $_SESSION['page_no'] = $_SESSION['page_count'] - 1;
//     }
//     if($_SESSION['page_no'] >= $_SESSION['page_count']){
//         $_SESSION['page_no'] = 0;
//     }
//     $sql = "SELECT * FROM hang_hoa ORDER BY ma_hh LIMIT ".$_SESSION['page_no'].", 10";
//     return pdo_query($sql);
// }
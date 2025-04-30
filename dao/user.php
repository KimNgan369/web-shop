<?php
// require_once 'pdo.php';

function user_insert($username, $password, $email){
    $sql = "INSERT INTO users(username, password, email) VALUES (?, ?, ?)";
    pdo_execute($sql, $username, $password, $email);
}

function user_exist($username) {
    $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    return pdo_query_value($sql, $username) > 0;
}

function email_exist($email) {
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    return pdo_query_value($sql, $email) > 0;
}

function checkuser($email, $password) {
    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    return pdo_query_one($sql, $email, $password);
    
    // if (is_array($kq) && count($kq)) {
    //     return $kq["id"];
    // } else {
    //     return 0;
    // }
}


// function user_update($ma_kh, $mat_khau, $ho_ten, $email, $hinh, $kich_hoat, $vai_tro){
//     $sql = "UPDATE users SET mat_khau=?,ho_ten=?,email=?,hinh=?,kich_hoat=?,vai_tro=? WHERE ma_kh=?";
//     pdo_execute($sql, $mat_khau, $ho_ten, $email, $hinh, $kich_hoat==1, $vai_tro==1, $ma_kh);
// }

// function user_delete($ma_kh){
//     $sql = "DELETE FROM users  WHERE ma_kh=?";
//     if(is_array($ma_kh)){
//         foreach ($ma_kh as $ma) {
//             pdo_execute($sql, $ma);
//         }
//     }
//     else{
//         pdo_execute($sql, $ma_kh);
//     }
// }

// function user_select_all(){
//     $sql = "SELECT * FROM users";
//     return pdo_query($sql);
// }

// function user_select_by_id($ma_kh){
//     $sql = "SELECT * FROM users WHERE ma_kh=?";
//     return pdo_query_one($sql, $ma_kh);
// }

// function user_exist($ma_kh){
//     $sql = "SELECT count(*) FROM users WHERE $ma_kh=?";
//     return pdo_query_value($sql, $ma_kh) > 0;
// }

// function user_select_by_role($vai_tro){
//     $sql = "SELECT * FROM users WHERE vai_tro=?";
//     return pdo_query($sql, $vai_tro);
// }

// function user_change_password($ma_kh, $mat_khau_moi){
//     $sql = "UPDATE users SET mat_khau=? WHERE ma_kh=?";
//     pdo_execute($sql, $mat_khau_moi, $ma_kh);
// }
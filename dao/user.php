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

function user_update($username, $password, $email, $address, $phone, $role, $id){
    $sql = "UPDATE users SET username=?,password=?,email=?,address=?,phone=?,role=? WHERE id=?";
    pdo_execute($sql, $username, $password, $email, $address, $phone, $role, $id);
}

function checkuser($email, $password) {
    $sql = "SELECT * FROM users WHERE email=? AND password=?";
    return pdo_query_one($sql, $email, $password);
}

function get_user($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Verify if the current password is correct for the given user ID
 */
function verify_current_password($user_id, $current_password) {
    $sql = "SELECT * FROM users WHERE id = ? AND password = ?";
    $user = pdo_query_one($sql, $user_id, $current_password);
    return is_array($user) && count($user) > 0;
}

/**
 * Change the user's password
 */
function user_change_password($user_id, $new_password) {
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    pdo_execute($sql, $new_password, $user_id);
}

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
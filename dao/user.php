<?php
require_once 'pdo.php';

function user_insert($username, $password, $email, $full_name, $phone, $address, $role, $is_vip) {
    $sql = "INSERT INTO users (username, password, email, full_name, phone, address, role, is_vip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $username, $password, $email, $full_name, $phone, $address, $role, $is_vip);
}

function user_insert_vip($username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $total_spent) {
    $sql = "INSERT INTO users (username, password, email, full_name, phone, address, role, is_vip, total_spent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    pdo_execute($sql, $username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $total_spent);
}

function user_update($username, $email, $full_name, $phone, $address, $role, $is_vip, $id) {
    $sql = "UPDATE users SET username = ?, email = ?, full_name = ?, phone = ?, address = ?, role = ?, is_vip = ? WHERE id = ?";
    pdo_execute($sql, $username, $email, $full_name, $phone, $address, $role, $is_vip, $id);
}

function user_update_vip($username, $email, $full_name, $phone, $address, $role, $is_vip, $total_spent, $id) {
    $sql = "UPDATE users SET username = ?, email = ?, full_name = ?, phone = ?, address = ?, role = ?, is_vip = ?, total_spent = ? WHERE id = ?";
    pdo_execute($sql, $username, $email, $full_name, $phone, $address, $role, $is_vip, $total_spent, $id);
}

function user_update_with_password($username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $id) {
    $sql = "UPDATE users SET username = ?, password = ?, email = ?, full_name = ?, phone = ?, address = ?, role = ?, is_vip = ? WHERE id = ?";
    pdo_execute($sql, $username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $id);
}

function user_update_vip_with_password($username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $total_spent, $id) {
    $sql = "UPDATE users SET username = ?, password = ?, email = ?, full_name = ?, phone = ?, address = ?, role = ?, is_vip = ?, total_spent = ? WHERE id = ?";
    pdo_execute($sql, $username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $total_spent, $id);
}

function user_delete($id) {
    $sql = "DELETE FROM users WHERE id = ?";
    pdo_execute($sql, $id);
}

function get_all_users() {
    $sql = "SELECT * FROM users ORDER BY id DESC";
    return pdo_query($sql);
}

function get_vip_users() {
    $sql = "SELECT id, username, full_name, email, phone, address, role, is_vip, total_spent FROM users WHERE is_vip = 1 ORDER BY id DESC";
    return pdo_query($sql);
}

function get_user($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    return pdo_query_one($sql, $id);
}

function user_exist($username) {
    $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    return pdo_query_value($sql, $username) > 0;
}

function email_exist($email) {
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    return pdo_query_value($sql, $email) > 0;
}
?>
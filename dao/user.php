<?php
require_once 'pdo.php';

/**
 * Insert a new user
 */
function user_insert($username, $password, $email, $full_name = '', $phone = '', $address = '', $role = 'user', $is_vip = 0) {
    $sql = "INSERT INTO users(username, password, email, full_name, phone, address, role, is_vip, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    pdo_execute($sql, $username, $password, $email, $full_name, $phone, $address, $role, $is_vip);
}

/**
 * Check if username already exists
 */
function user_exist($username) {
    $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    return pdo_query_value($sql, $username) > 0;
}

/**
 * Check if email already exists
 */
function email_exist($email) {
    $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
    return pdo_query_value($sql, $email) > 0;
}

/**
 * Update user information
 */
function user_update($username, $email, $full_name, $phone, $address, $role, $is_vip, $id) {
    $sql = "UPDATE users SET 
            username = ?,
            email = ?,
            full_name = ?,
            phone = ?,
            address = ?,
            role = ?,
            is_vip = ?,
            updated_at = NOW()
            WHERE id = ?";
    pdo_execute($sql, $username, $email, $full_name, $phone, $address, $role, $is_vip, $id);
}

/**
 * Update user with new password
 */
function user_update_with_password($username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $id) {
    $sql = "UPDATE users SET 
            username = ?,
            password = ?,
            email = ?,
            full_name = ?,
            phone = ?,
            address = ?,
            role = ?,
            is_vip = ?,
            updated_at = NOW()
            WHERE id = ?";
    pdo_execute($sql, $username, $password, $email, $full_name, $phone, $address, $role, $is_vip, $id);
}

/**
 * Delete user by ID
 */
function user_delete($id) {
    $sql = "DELETE FROM users WHERE id = ?";
    pdo_execute($sql, $id);
}

/**
 * Check if user exists with given email and password
 */
function checkuser($email, $password) {
    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    return pdo_query_one($sql, $email, $password);
}

/**
 * Get user by ID
 */
function get_user($id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    return pdo_query_one($sql, $id);
}

/**
 * Get all users
 */
function get_all_users() {
    $sql = "SELECT * FROM users ORDER BY id DESC";
    return pdo_query($sql);
}

/**
 * Get users by role
 */
function get_users_by_role($role) {
    $sql = "SELECT * FROM users WHERE role = ? ORDER BY id DESC";
    return pdo_query($sql, $role);
}

/**
 * Get VIP users
 */
function get_vip_users() {
    $sql = "SELECT * FROM users WHERE is_vip = 1 ORDER BY id DESC";
    return pdo_query($sql);
}

/**
 * Count total users
 */
function count_users() {
    $sql = "SELECT COUNT(*) FROM users";
    return pdo_query_value($sql);
}

/**
 * Count total VIP users
 */
function count_vip_users() {
    $sql = "SELECT COUNT(*) FROM users WHERE is_vip = 1";
    return pdo_query_value($sql);
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
    $sql = "UPDATE users SET password = ?, updated_at = NOW() WHERE id = ?";
    pdo_execute($sql, $new_password, $user_id);
}

/**
 * Update user's total spent
 */
function update_user_total_spent($user_id, $amount) {
    $sql = "UPDATE users SET total_spent = total_spent + ?, updated_at = NOW() WHERE id = ?";
    pdo_execute($sql, $amount, $user_id);
}

/**
 * Update user's VIP status based on total spent
 * For example: If total_spent > 1000000, set is_vip = 1
 */
function update_vip_status($user_id) {
    $sql = "UPDATE users SET is_vip = CASE WHEN total_spent >= 1000000 THEN 1 ELSE 0 END, updated_at = NOW() WHERE id = ?";
    pdo_execute($sql, $user_id);
}

/**
 * Search users by keyword in username, email, or full_name
 */
function search_users($keyword) {
    $sql = "SELECT * FROM users 
            WHERE username LIKE ? OR email LIKE ? OR full_name LIKE ? 
            ORDER BY id DESC";
    $search_param = "%" . $keyword . "%";
    return pdo_query($sql, $search_param, $search_param, $search_param);
}
?>
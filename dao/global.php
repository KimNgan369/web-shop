<?php
// Ngăn định nghĩa lại hằng số
if (!defined('IMG_PATH_ADMIN')) {
    define('IMG_PATH_ADMIN', '../upload/');
}

if (!defined('IMG_PATH')) {
    define('IMG_PATH', 'upload/');
}

// Đường dẫn web tương đối
$base_url = dirname($_SERVER['SCRIPT_NAME']);
?>
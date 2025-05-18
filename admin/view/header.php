<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Trang Sức</title>
  <!-- Liên kết tới file CSS bên ngoài -->
  <link rel="stylesheet" href="layout/css/admin.css">
  <script src="layout/js/admin.js"></script>

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="brand">
      <img src="layout/img/whitelogo.png" alt="Logo" style="width: 50px; height: auto; border-radius: 50%;">
    </div>
    <ul class="menu">
      <li onclick="window.location.href='index.php'">Tổng quan</li>      
      <li onclick="window.location.href='index.php?act=sanphamlist'">Quản lý sản phẩm</li>
      <li onclick="window.location.href='index.php?act=manage_user'">Quản lý người dùng</li>
      <li><a href="index.php?act=manage_orders">Quản lý đơn hàng</a></li>
      <li onclick="window.location.href='index.php?act=manage_vip'">Quản lý VIP</li>

      <li onclick="window.location.href='index.php?act=logout'">Logout</li>    </ul>
  </div>

  
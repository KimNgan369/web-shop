<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard - Trang Sức</title>
  <!-- Liên kết tới file CSS bên ngoài -->
  <link rel="stylesheet" href="layout/css/admin.css">

  <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
</head>
<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="brand">
      <img src="layout/img/whitelogo.png" alt="Logo" style="width: 50px; height: auto; border-radius: 50%;">
    </div>
    <ul class="menu">
      <li class="active" onclick="showSection('dashboard', this)">Tổng quan</li>
      <li onclick="showSection('manage-products', this)">Quản lý sản phẩm</li>
      <li onclick="showSection('manage-orders', this)">Quản lý đơn hàng</li>
      <li onclick="showSection('manage-users', this)">Quản lý người dùng</li>
      <li onclick="showSection('manage-vip', this)">Quản lý VIP</li>
      <li onclick="showSection('manage-feedback', this)">Feedback</li>
      <li onclick="window.location.href='index.php?act=logout'">Logout</li>    </ul>
  </div>
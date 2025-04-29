  <!-- Main Content -->
  <div class="main-content">
    <!-- Header hiển thị tên mục theo menu -->
    <header class="main-header">
      <h1 id="section-title">Tổng quan</h1>
      <!-- Icon tài khoản -->
      <img 
        class="account-icon" 
        src="https://cdn-icons-png.flaticon.com/512/747/747376.png" 
        alt="Account Icon"
      />
    </header>

    <!-- Phần Tổng quan (Dashboard) -->
    <div id="dashboard" class="section active">
      <!-- Thẻ thống kê -->
      <div class="dashboard-cards">
        <div class="card">
          <h3>Sản phẩm</h3>
          <p>120</p>
        </div>
        <div class="card">
          <h3>Đơn hàng</h3>
          <p>45</p>
        </div>
        <div class="card">
          <h3>Người dùng</h3>
          <p>300</p>
        </div>
        <div class="card">
          <h3>Khách VIP</h3>
          <p>10</p>
        </div>
      </div>

      <!-- Biểu đồ (tùy chọn) -->
      <div class="chart-section">
        <h3>Xu hướng doanh thu</h3>
        <canvas id="myChart" width="400" height="150"></canvas>
      </div>

      <!-- Thông tin nổi bật và Tasks -->
      <div class="info-section">
        <div class="highlight-info">
          <h3>Thông tin nổi bật</h3>
          <ul>
            <li>Sản phẩm bán chạy nhất: Nhẫn kim cương</li>
            <li>Doanh thu hôm nay: 30,000,000 VNĐ</li>
            <li>Khách hàng mới: 15</li>
            <li>Số đơn hàng chờ xử lý: 5</li>
          </ul>
        </div>
        <div class="task-list">
          <h3>Nhiệm vụ</h3>
          <ul>
            <li>Thêm sản phẩm mới</li>
            <li>Duyệt feedback</li>
            <li>Kiểm tra hàng tồn kho</li>
            <li>Kiểm tra đơn VIP mới</li>
          </ul>
        </div>
      </div>
    </div>

    
  <!-- Liên kết tới file JavaScript bên ngoài -->
  <script src="layout/js/admin.js"></script>
</body>
</html>
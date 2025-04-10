
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

    <!-- Quản lý sản phẩm -->
    <div id="manage-products" class="section">
      <div class="product-management">
        <button class="button-add">Thêm sản phẩm mới</button>
        <table class="product-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên sản phẩm</th>
              <th>Danh mục</th>
              <th>Giá</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Nhẫn kim cương</td>
              <td>Nhẫn</td>
              <td>5,000,000 VNĐ</td>
              <td>
                <button class="edit-btn">Sửa</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Vòng tay vàng</td>
              <td>Vòng tay</td>
              <td>3,200,000 VNĐ</td>
              <td>
                <button class="edit-btn">Sửa</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quản lý đơn hàng -->
    <div id="manage-orders" class="section">
      <div class="order-management">
        <table class="order-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên khách hàng</th>
              <th>Ngày đặt hàng</th>
              <th>Tổng tiền</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1001</td>
              <td>Trần Thị Kim Ngân</td>
              <td>01/04/2025</td>
              <td>8,000,000 VNĐ</td>
              <td>Chờ xử lý</td>
              <td>
                <button class="detail-btn">Xem chi tiết</button>
              </td>
            </tr>
            <tr>
              <td>1002</td>
              <td>Nguyễn Văn A</td>
              <td>02/04/2025</td>
              <td>12,500,000 VNĐ</td>
              <td>Đang giao</td>
              <td>
                <button class="detail-btn">Xem chi tiết</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quản lý người dùng -->
    <div id="manage-users" class="section">
      <div class="user-management">
        <button class="button-add">Thêm người dùng mới</button>
        <table class="user-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên người dùng</th>
              <th>Email</th>
              <th>Trạng thái</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>U001</td>
              <td>Trần Thị Kim Ngân</td>
              <td>nva@example.com</td>
              <td>Active</td>
              <td>
                <button class="edit-btn">Sửa</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
            <tr>
              <td>U002</td>
              <td>Nguyễn Văn A</td>
              <td>ttb@example.com</td>
              <td>Inactive</td>
              <td>
                <button class="edit-btn">Sửa</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quản lý VIP (đồng bộ ID người dùng với phần Quản lý người dùng) -->
    <div id="manage-vip" class="section">
      <div class="vip-management">
        <button class="button-add">Thêm VIP mới</button>
        <table class="vip-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên VIP</th>
              <th>Email</th>
              <th>Ngày đạt VIP</th>
              <th>Tổng chi tiêu</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <!-- Sử dụng ID người dùng từ phần Quản lý người dùng -->
              <td>U001</td>
              <td>Trần Thị Kim Ngân</td>
              <td>nva@example.com</td>
              <td>15/03/2025</td>
              <td>6,000,000 VNĐ</td>
              <td>
                <button class="edit-btn">Sửa</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
            <tr>
              <td>U002</td>
              <td>Nguyễn Văn A</td>
              <td>ttb@example.com</td>
              <td>18/03/2025</td>
              <td>7,500,000 VNĐ</td>
              <td>
                <button class="edit-btn">Sửa</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Feedback -->
    <div id="manage-feedback" class="section">
      <div class="feedback-management">
        <table class="feedback-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên người dùng</th>
              <th>Nội dung</th>
              <th>Ngày</th>
              <th>Hành động</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <!-- Dùng ID người dùng từ phần Quản lý người dùng -->
              <td>U001</td>
              <td>Trần Thị Kim Ngân</td>
              <td>Rất hài lòng với sản phẩm và dịch vụ.</td>
              <td>03/04/2025</td>
              <td>
                <button class="detail-btn">Duyệt</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
            <tr>
              <td>U002</td>
              <td>Nguyễn Văn A</td>
              <td>Sản phẩm chưa đáp ứng kỳ vọng.</td>
              <td>04/04/2025</td>
              <td>
                <button class="detail-btn">Duyệt</button>
                <button class="delete-btn">Xóa</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    
  </div>

  <!-- Liên kết tới file JavaScript bên ngoài -->
  <script src="layout/js/admin.js"></script>
</body>
</html>
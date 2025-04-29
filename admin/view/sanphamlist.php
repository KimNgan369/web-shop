<?php

$html_sanphamlist =''; 
    foreach($sanphamlist as $sp) {
        extract($sp);
        $html_sanphamlist .= '<tr>
                                <td>'.$id.'</td>
                                <td>'.$name.'</td>
                                <td><img src="'.IMG_PATH_ADMIN.$image.'" alt="" width="50px"></td>
                                <td>'.$category_name.'</td>
                                <td>'.$price.'</td>
                                <td>
                                  <a href="index.php?act=updateproduct&id='.$id.'" class="edit-btn">Sửa</a>
                                  <a href="index.php?act=delproduct&id='.$id.'" class="delete-btn">Xóa</a>
                                </td>
                              </tr>';
    }
?>
<div class="main-content">
    <!-- Header hiển thị tên mục theo menu -->
    <header class="main-header">
      <h1 id="section-title">Quản lý sản phẩm</h1>
      <!-- Icon tài khoản -->
      <img 
        class="account-icon" 
        src="https://cdn-icons-png.flaticon.com/512/747/747376.png" 
        alt="Account Icon"
      />
    </header>
<div>
    <div class="product-management">
        <a href="index.php?act=sanphamadd" class="button-add">Thêm sản phẩm mới</a>
      <table class="product-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?=$html_sanphamlist;?>
          <!-- <tr>
            <td>1</td>
            <td>Nhẫn kim cương</td>
            
            <td>Nhẫn</td>
            <td>5,000,000 VNĐ</td>
            <td>
              <button class="edit-btn">Sửa</button>
              <button class="delete-btn">Xóa</button>
            </td>
          </tr>
          <tr> -->
            <!-- <td>2</td>
            <td>Vòng tay vàng</td>
            <td>Vòng tay</td>
            <td>3,200,000 VNĐ</td>
            <td>
              <button class="edit-btn">Sửa</button>
              <button class="delete-btn">Xóa</button>
            </td> -->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

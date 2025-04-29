<?php
    $html_danhmuclist ='';
    foreach ($danhmuclist as $dm) {
        extract($dm);
        $html_danhmuclist .='<option value="'.$id.'">'.$name.'</option>';
    }


?>


<div class="main-content">
    <!-- Header hiển thị tên mục theo menu -->
    <header class="main-header">
      <h1 id="section-title">Thêm sản phẩm</h1>
      <!-- Icon tài khoản -->
      <img 
        class="account-icon" 
        src="https://cdn-icons-png.flaticon.com/512/747/747376.png" 
        alt="Account Icon"
      />
    </header>

<div class="add-product">
    <form class="addPro" action="index.php?act=addproduct" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="productImage">Ảnh sản phẩm</label>
            <div class="custom-file-container">
                <input type="file" name="image" class="custom-file-input" id="productImage" onchange="updateFileName()">
                <label class="custom-file-label" for="productImage">Chọn tệp</label>
            </div>
        </div>

        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Nhập tên sản phẩm">
        </div>
        <div class="form-group">
            <label for="name">Mô tả:</label>
            <input type="text" class="form-control" name="description" id="name" placeholder="Nhập mô tả sản phẩm">
        </div>
        <div class="form-group">
            <label for="categories">Danh mục:</label>
            <select class="form-select" name="danhmuc" aria-label="Default select example">
                <option selected>Chọn danh mục</option>
                <?=$html_danhmuclist;?>
                <!-- <option value="1">Earrings</option>
                <option value="2">Necklaces</option>
                <option value="3">Bracelets</option>
                <option value="4">Rings</option> -->
            </select>
        </div>
        <!-- Phần Material -->
        <div class="form-group">
            <label for="categories">Material:</label>
            <select class="form-select" name="material" aria-label="Default select example">
                <option selected>Chọn material</option>
                <option value="Golden">Golden</option>
                <option value="Silver">Silver</option>
                <option value="Titan">Titan</option>
                <option value="Diamond">Diamond</option>
            </select>
        </div>

        <!-- Phần Style -->
        <div class="form-group">
            <label for="categories">Style:</label>
            <select class="form-select" name="style" aria-label="Default select example">
                <option selected>Chọn style</option>
                <option value="Bold">Bold</option>
                <option value="Hidden">Hidden</option>
                <option value="Protection">Protection</option>
                <option value="Themes">Themes</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="price">Giá:</label>
            <div class="input-group">
                
                <input type="text" name="price" id="price" class="form-control" placeholder="Nhập giá">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="addproduct" class="btn btn-primary">Thêm sản phẩm</button>
        </div>
    </form>
</div>
<script src="layout/js/admin.js"></script>

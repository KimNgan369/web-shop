<?php
// Khởi tạo các biến
$image_display = "";
$imgpath = "";
$name = isset($sp['name']) ? $sp['name'] : "";
$description = isset($sp['description']) ? $sp['description'] : "";
$category_id = isset($sp['category_id']) ? $sp['category_id'] : "";
$material = isset($sp['material']) ? $sp['material'] : "";
$style = isset($sp['style']) ? $sp['style'] : "";
$price = isset($sp['price']) ? $sp['price'] : "";

// Xử lý hiển thị ảnh
if(isset($sp['image']) && !empty($sp['image'])) {
    $imgpath = IMG_PATH_ADMIN.$sp['image'];
    if(is_file($imgpath)) {
        $image_display = '<img src="'.$imgpath.'" width="50px">';
    }
}

// Xử lý danh mục
$html_danhmuclist = '';
foreach ($danhmuclist as $dm) {
    $selected = ($dm['id'] == $category_id) ? 'selected' : '';
    $html_danhmuclist .= '<option value="'.$dm['id'].'" '.$selected.'>'.$dm['name'].'</option>';
}
?>

<head>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<div class="main-content">
    <!-- Header hiển thị tên mục theo menu -->
    <header class="main-header">
      <h1 id="section-title">Cập nhật sản phẩm</h1>
      <!-- Icon tài khoản -->
      <img 
        class="account-icon" 
        src="https://cdn-icons-png.flaticon.com/512/747/747376.png" 
        alt="Account Icon"
      />

    </header>

<div class="add-product">
    <form class="addPro" action="index.php?act=addproducts" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=isset($sp['id']) ? $sp['id'] : ''?>">
        <div class="form-group">
            <label for="productImage">Ảnh sản phẩm</label>
            <span><?=$imgpath?></span> <!-- Hiển thị đường dẫn riêng -->
            <div class="custom-file-container">
                <input type="file" name="image" class="custom-file-input" id="productImage" onchange="updateFileName()">
                <?=$image_display?>
                <label class="custom-file-label" for="productImage">Chọn tệp</label>
            </div>
        </div>

        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" class="form-control" name="name" value="<?=($name!="")?$name:"";?>" id="name" placeholder="Nhập tên sản phẩm">
        </div>
        <div class="form-group">
            <label for="name">Mô tả:</label>
            <textarea class="form-control" name="description" id="description" placeholder="Nhập mô tả sản phẩm"><?=htmlspecialchars($description)?></textarea>        </div>
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
                <option value="">Chọn material</option>
                <option value="Golden" <?=($material=='Golden')?'selected':''?>>Golden</option>
                <option value="Silver" <?=($material=='Silver')?'selected':''?>>Silver</option>
                <option value="Titan" <?=($material=='Titan')?'selected':''?>>Titan</option>
                <option value="Diamond" <?=($material=='Diamond')?'selected':''?>>Diamond</option>
            </select>
        </div>

        <!-- Phần Style -->
        <div class="form-group">
            <label for="categories">Style:</label>
            <select class="form-select" name="style" aria-label="Default select example">
                <option selected>Chọn style</option>
                <option value="Bold" <?=($style=='Bold')?'selected':''?>>Bold</option>
                <option value="Hidden" <?=($style=='Hidden')?'selected':''?>>Hidden</option>
                <option value="Protection" <?=($style=='Protection')?'selected':''?>>Protection</option>
                <option value="Themes" <?=($style=='Themes')?'selected':''?>>Themes</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="price">Giá:</label>
            <div class="input-group">
                
                <input type="text" name="price" id="price" value="<?=($price!="")?$price:"";?>"  class="form-control" placeholder="Nhập giá">
            </div>
        </div>
        <div class="form-group">
            <button type="submit" name="addproducts" class="btn btn-primary">Cập nhật sản phẩm</button>
        </div>

    </form>
</div>
<script src="layout/js/admin.js"></script>
<script>
        CKEDITOR.replace('description');
</script>
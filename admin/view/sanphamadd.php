<?php
$html_danhmuclist = '';
foreach ($danhmuclist as $dm) {
    extract($dm);
    $html_danhmuclist .= '<option value="' . $id . '">' . $name . '</option>';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
</head>
<body>
    <div class="main-content">
        <header class="main-header">
            <h1 id="section-title">Thêm sản phẩm</h1>
            <img class="account-icon" src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="Account Icon"/>
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
                    <label for="description">Mô tả:</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Nhập mô tả sản phẩm"></textarea>
                </div>
                <div class="form-group">
                    <label for="categories">Danh mục:</label>
                    <select class="form-select" name="danhmuc" aria-label="Default select example">
                        <option selected>Chọn danh mục</option>
                        <?php echo $html_danhmuclist; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="material">Material:</label>
                    <select class="form-select" name="material" aria-label="Default select example">
                        <option selected>Chọn material</option>
                        <option value="Golden">Golden</option>
                        <option value="Silver">Silver</option>
                        <option value="Titan">Titan</option>
                        <option value="Diamond">Diamond</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="style">Style:</label>
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
                    <a href="index.php?act=sanphamlist" class="btn btn-primary">Quay lại danh sách</a>
                </div>
            </form>
        </div>
    </div>
    <script src="layout/js/admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
</body>
</html>
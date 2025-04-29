function showSection(sectionId, element) {
    // Ẩn tất cả các section
    const sections = document.querySelectorAll('.section');
    sections.forEach(sec => sec.classList.remove('active'));
    // Hiển thị section được chọn
    document.getElementById(sectionId).classList.add('active');
    
    // Cập nhật tiêu đề trên header
    const sectionTitle = document.getElementById('section-title');
    sectionTitle.innerText = element.innerText;
  
    // Cập nhật trạng thái active cho các menu item
    const menuItems = document.querySelectorAll('.menu li');
    menuItems.forEach(item => item.classList.remove('active'));
    element.classList.add('active');
  }
  function updateFileName() {
    const fileInput = document.getElementById('productImage');
    const fileLabel = document.querySelector('.custom-file-label');

    if (fileInput.files.length > 0) {
        // Lấy tên của tệp đã chọn
        const fileName = fileInput.files[0].name;

        // Cập nhật tên tệp vào label
        fileLabel.textContent = fileName;
    } else {
        // Nếu không có tệp nào được chọn, hiển thị dòng chữ mặc định
        fileLabel.textContent = "Chưa có tệp nào được chọn";
    }
}

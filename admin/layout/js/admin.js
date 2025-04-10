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

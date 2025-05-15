<?php
require_once 'header.php';
?>

<div class="container-contact">
    <h1>Liên Hệ Với Chúng Tôi</h1>
    <p class="subtitle">Kết nối với chúng tôi qua các kênh dưới đây để được hỗ trợ nhanh nhất!</p>
    <div class="contact-methods">
        <div class="contact-item">
            <i class="fab fa-facebook"></i>
            <a href="https://www.facebook.com/yourpage" target="_blank">Facebook</a>
            <p>Nhắn tin trực tiếp với đội ngũ hỗ trợ</p>
        </div>
        <div class="contact-item">
            <i class="fab fa-whatsapp"></i> 
            <a href="https://zalo.me/yourzalo" target="_blank">Zalo</a>
            <p>Liên hệ nhanh qua Zalo</p>
        </div>
    </div>

    <!-- Phần bản đồ OpenStreetMap với Leaflet -->
    <div class="map-section">
        <h2 class="map-title">Địa Chỉ Cửa Hàng</h2>
        <p class="map-subtitle">Hãy ghé thăm chúng tôi tại địa chỉ dưới đây!</p>
        <div id="map" style="height: 400px; width: 100%; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);"></div>
    </div>
</div>

<!-- Tải Leaflet CSS và JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Script để khởi tạo bản đồ OpenStreetMap -->
<script>
    var map = L.map('map').setView([10.733279, 106.700076], 15); // Tọa độ cửa hàng, zoom level 15
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { //Áp dụng API
        maxZoom: 19,
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Thêm marker tại vị trí cửa hàng
    var marker = L.marker([10.733279, 106.700076]).addTo(map);
    marker.bindPopup("MYTH Store").openPopup();
</script>

</body>
</html>

<style>
    .container-contact {
        max-width: 900px;
        margin: 100px auto 40px auto; 
        padding: 0 20px;
        text-align: center;
    }
    h1 {
        font-size: 2.8em;
        color: #000000;
        margin-bottom: 10px;
        position: relative;
        display: inline-block;
        font-weight: 700;
    }
    h1::after {
        content: '';
        width: 50px;
        height: 4px;
        background-color: #EAD169;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .subtitle {
        font-size: 1.2em;
        color: #000000;
        margin-bottom: 40px;
        opacity: 0.8;
        font-weight: 400;
    }
    .contact-methods {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
        padding: 0 20px;
        margin-bottom: 60px;
    }
    .contact-item {
        background-color: #EAD169;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, background-color 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .contact-item:hover {
        background-color: #EBD96B;
        transform: translateY(-5px);
    }
    .contact-item i {
        font-size: 2.5em;
        color: #000000;
        margin-bottom: 15px;
    }
    .contact-item a {
        text-decoration: none;
        color: #000000;
        font-size: 1.4em;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .contact-item p {
        margin: 0;
        font-size: 1em;
        color: #000000;
        opacity: 0.7;
    }
    .map-section {
        margin-top: 40px;
        padding: 20px 0;
    }
    .map-title {
        font-size: 2em;
        color: #000000;
        margin-bottom: 10px;
        position: relative;
        display: inline-block;
        font-weight: 700;
    }
    .map-title::after {
        content: '';
        width: 40px;
        height: 4px;
        background-color: #EAD169;
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 2px;
    }
    .map-subtitle {
        font-size: 1.1em;
        color: #000000;
        margin-bottom: 20px;
        opacity: 0.8;
        font-weight: 400;
    }
    @media (max-width: 600px) {
        h1, .map-title {
            font-size: 2.2em;
        }
        .contact-item {
            padding: 20px;
        }
        .contact-item i {
            font-size: 2em;
        }
        #map {
            height: 300px;
        }
    }
</style>
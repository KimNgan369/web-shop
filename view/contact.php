<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên Hệ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #FEFEFE;
            color: #000000;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 60px 20px;
            text-align: center;
        }
        h1 {
            font-size: 2.8em;
            color: #000000;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
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
        }
        .contact-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 0 20px;
        }
        .contact-item {
            background-color: #EAD169;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, background-color 0.3s;
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
            display: block;
            margin-bottom: 10px;
        }
        .contact-item p {
            margin: 0;
            font-size: 1em;
            color: #000000;
            opacity: 0.7;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 2.2em;
            }
            .contact-item {
                padding: 20px;
            }
            .contact-item i {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liên Hệ Với Chúng Tôi</h1>
        <p class="subtitle">Kết nối với chúng tôi qua các kênh dưới đây để được hỗ trợ nhanh nhất!</p>
        <div class="contact-methods">
            <div class="contact-item">
                <i class="fab fa-facebook"></i>
                <a href="https://www.facebook.com/yourpage" target="_blank">Facebook</a>
                <p>Nhắn tin trực tiếp với đội ngũ hỗ trợ</p>
            </div>
            <div class="contact-item">
                <i class="fab fa-whatsapp"></i> <!-- Sử dụng WhatsApp làm placeholder vì Font Awesome không có icon Zalo -->
                <a href="https://zalo.me/yourzalo" target="_blank">Zalo</a>
                <p>Liên hệ nhanh qua Zalo</p>
            </div>
        </div>
    </div>
</body>
</html>
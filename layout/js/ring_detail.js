let currentIndex = 0;

const mainImageContainer = document.querySelector('.main-image-container');
const mainImage = document.querySelector('.main-image img');
const leftArrow = document.querySelector('.main-image-container .left-arrow');
const rightArrow = document.querySelector('.main-image-container .right-arrow');
const thumbnailImages = document.querySelectorAll('.thumbnail');
const addToCartBtn = document.getElementById('addToCartBtn');
const cartIcon = document.getElementById('cartIcon');
const tryNowBtn = document.querySelector('.try-now');

const originalMainImageHTML = document.querySelector('.main-image').innerHTML;

function updateMainImage() {
    mainImage.src = thumbnails[currentIndex];
}

document.addEventListener('DOMContentLoaded', () => {
    updateMainImage();
});

leftArrow.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
    updateMainImage();
});

rightArrow.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % thumbnails.length;
    updateMainImage();
});

thumbnailImages.forEach((thumb, index) => {
    thumb.addEventListener('click', () => {
        currentIndex = index;
        updateMainImage();
    });
});

addToCartBtn.addEventListener('click', () => {
    const img = mainImage.cloneNode(true);
    img.style.position = 'fixed';
    img.style.top = mainImage.getBoundingClientRect().top + 'px';
    img.style.left = mainImage.getBoundingClientRect().left + 'px';
    img.style.width = mainImage.offsetWidth + 'px';
    img.style.height = mainImage.offsetHeight + 'px';
    img.style.transition = 'all 1s ease-in-out';
    img.style.zIndex = '1000';

    document.body.appendChild(img);

    setTimeout(() => {
        img.style.top = '20px';
        img.style.left = '90%';
        img.style.width = '50px';
        img.style.height = '50px';
        img.style.opacity = '0.5';
    }, 10);

    setTimeout(() => {
        img.remove();
        cartIcon.style.display = 'block';
        cartIcon.classList.add('animate__animated', 'animate__bounce');
        setTimeout(() => {
            cartIcon.classList.remove('animate__animated', 'animate__bounce');
        }, 1000);
    }, 1000);
});

// Try Now - Bật Camera
// Try Now - Bật Camera
tryNowBtn.addEventListener('click', () => {
    const mainImageDiv = document.querySelector('.main-image');
    mainImageDiv.innerHTML = `
        <div style="position: relative;">
            <video id="cameraStream" autoplay style="width: 100%; height: auto; border-radius: 10px; transform: scaleX(-1);"></video>
            <img src="../layout/img/hand_frame.png" alt="Hand Frame" 
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 60%; opacity: 0.5;">
            <button id="closeCamera" class="btn btn-danger" 
                style="position: absolute; top: 10px; right: 10px; border-radius: 50%; width: 40px; height: 40px;">
                &times;
            </button>
            <button id="switchCamera" class="btn btn-warning" 
                style="position: absolute; bottom: 10px; right: 10px; border-radius: 10px;">
                Switch Camera
            </button>
        </div>
    `;

    let currentStream = null;
    let usingFrontCamera = true; // Mặc định dùng camera trước

    function startCamera(facingMode = "user") {
        if (currentStream) {
            currentStream.getTracks().forEach(track => track.stop());
        }
        navigator.mediaDevices.getUserMedia({ video: { facingMode: facingMode } })
            .then(stream => {
                currentStream = stream;
                const video = document.getElementById('cameraStream');
                video.srcObject = stream;
                if (facingMode === "user") {
                    video.style.transform = "scaleX(-1)"; // Mirror nếu là camera trước
                } else {
                    video.style.transform = "scaleX(1)"; // Không mirror nếu là camera sau
                }
            })
            .catch(err => {
                console.error("Không thể truy cập camera:", err);
                mainImageDiv.innerHTML = '<p class="text-danger">Không thể bật camera!</p>';
            });
    }

    startCamera(); // Bắt đầu với camera trước

    mainImageDiv.addEventListener('click', (e) => {
        if (e.target.id === 'closeCamera') {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }
            mainImageDiv.innerHTML = originalMainImageHTML;
            updateMainImage();
        }

        if (e.target.id === 'switchCamera') {
            usingFrontCamera = !usingFrontCamera;
            startCamera(usingFrontCamera ? "user" : "environment");
        }
    });
});

const products = [
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "Hades Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "Ares Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
    { img: "../img/poseidon1.png", name: "poseidon Ring", price: "$120" },
    { img: "../img/zeus1.png", name: "zeus Ring", price: "$150" },
];

const productsPerPage = 9;
let currentPage = 1;

function renderProducts(page) {
    const productList = document.getElementById("product-list");
    productList.innerHTML = "";

    let start = (page - 1) * productsPerPage;
    let end = Math.min(start + productsPerPage, products.length);
    let pageProducts = products.slice(start, end);

    pageProducts.forEach(product => {
        let productHTML = `
            <div class="col-md-4">
                <div class="product-card">
                    <img src="${product.img}" alt="${product.name}">
                    <h5>${product.name}</h5>
                    <p>Price: ${product.price}</p>
                    <a href="#" class="text-primary">Explore Now!</a>
                </div>
            </div>
        `;
        productList.innerHTML += productHTML;
    });

    updatePagination();
}

function updatePagination() {
    const paginationContainer = document.querySelector(".pagination");
    paginationContainer.innerHTML = "";

    let totalPages = Math.ceil(products.length / productsPerPage);

    // Hiển thị số trang
    for (let i = 1; i <= totalPages; i++) {
        let activeClass = i === currentPage ? "active" : "";
        paginationContainer.innerHTML += `
            <li class="page-item ${activeClass}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }

    // Nút "»"
    paginationContainer.innerHTML += `
        <li class="page-item next-page">
            <a class="page-link" href="#">»</a>
        </li>
    `;

    setupPagination();
}

function setupPagination() {
    document.querySelectorAll(".page-link").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            let pageAttr = this.getAttribute("data-page");

            if (pageAttr) {
                currentPage = parseInt(pageAttr);
            } else if (this.parentElement.classList.contains("next-page")) {
                if (currentPage < Math.ceil(products.length / productsPerPage)) {
                    currentPage++;
                }
            }

            renderProducts(currentPage);
            highlightNextButton();
        });
    });
}

function highlightNextButton() {
    const nextButton = document.querySelector(".next-page a");
    if (currentPage === Math.ceil(products.length / productsPerPage)) {
        nextButton.style.color = "gray"; // Đổi màu khi đến trang cuối
    } else {
        nextButton.style.color = ""; // Reset màu khi chưa đến trang cuối
    }
}

// Khởi động trang đầu tiên
document.addEventListener("DOMContentLoaded", () => {
    renderProducts(currentPage);
    highlightNextButton();
});
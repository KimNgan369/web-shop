// Main JavaScript functionality for the MYTH Rings page

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('.search-container input');
    const searchButton = document.querySelector('.search-container button');
    
    searchButton.addEventListener('click', function() {
        performSearch(searchInput.value);
    });
    
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            performSearch(searchInput.value);
        }
    });
    
    // Filter button functionality
    const filterButton = document.querySelector('.filter-btn');
    filterButton.addEventListener('click', function() {
        applyFilters();
    });
    
    // Product card hover effects
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = 'none';
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Explore now button functionality
    const exploreButtons = document.querySelectorAll('.explore-btn');
    exploreButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productName = this.closest('.product-info').querySelector('h3').textContent;
            alert(`You clicked to explore ${productName}. This would take you to the product detail page.`);
        });
    });
    
    // Pagination functionality
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links
            paginationLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // In a real application, this would load the next page of products
            if (this.textContent === '›') {
                loadNextPage();
            } else {
                loadPage(parseInt(this.textContent));
            }
        });
    });
});

// Function to perform search
function performSearch(query) {
    if (query.trim() === '') {
        alert('Please enter a search term');
        return;
    }
    
    console.log(`Searching for: ${query}`);
    // In a real application, this would send an AJAX request to the server
    alert(`Search results for: ${query}`);
}

// Function to apply filters
function applyFilters() {
    const checkedBoxes = document.querySelectorAll('.checkbox-container input:checked');
    const filters = Array.from(checkedBoxes).map(box => box.parentElement.textContent.trim());
    
    console.log('Applied filters:', filters);
    // In a real application, this would update the product grid based on selected filters
    alert(`Filters applied: ${filters.join(', ')}`);
}

// Function to load next page
function loadNextPage() {
    console.log('Loading next page');
    // In a real application, this would load the next set of products
}

// Function to load specific page
function loadPage(pageNumber) {
    console.log(`Loading page ${pageNumber}`);
    // In a real application, this would load the specified page of products
}
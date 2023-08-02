'use strict';

function showDetail(productId) {
  let url = 'http://localhost:8888/New/public/detail/' + productId;
  window.location.href = url;
}

function addProduct() {
  let url = 'http://localhost:8888/New/public/add/';
  window.location.href = url;
}

document.addEventListener('DOMContentLoaded', function () {
  // Add event listener to the search button
  document.getElementById('search-button').addEventListener('click', searchProducts);

  // Add event listeners to the price and stock inputs for real-time filtering
  document.getElementById('min-price').addEventListener('input', searchProducts);
  document.getElementById('max-price').addEventListener('input', searchProducts);
  document.getElementById('min-stock').addEventListener('input', searchProducts);
  document.getElementById('max-stock').addEventListener('input', searchProducts);
});

// Function to handle product search with filters and sorting
function searchProducts(event) {
  if (event) event.preventDefault();

  // Get filter values
  const searchInput = document.getElementById('search-input').value;
  const manufacturerSelect = document.getElementById('manufacturer-select').value;
  const minPrice = document.getElementById('min-price').value;
  const maxPrice = document.getElementById('max-price').value;
  const minStock = document.getElementById('min-stock').value;
  const maxStock = document.getElementById('max-stock').value;

  // Build the search URL with parameters
  const searchParams = new URLSearchParams();

  if (searchInput) {
    searchParams.append('keyword', searchInput);
  }
  if (manufacturerSelect) {
    searchParams.append('manufacturer', manufacturerSelect);
  }
  if (minPrice) {
    searchParams.append('minPrice', minPrice);
  }
  if (maxPrice) {
    searchParams.append('maxPrice', maxPrice);
  }
  if (minStock) {
    searchParams.append('minStock', minStock);
  }
  if (maxStock) {
    searchParams.append('maxStock', maxStock);
  }

  const url = `http://localhost:8888/New/public/list?${searchParams.toString()}`;

  // Fetch the filtered and sorted products
  fetchProductList(url);
}

function fetchProductList(url) {
  $.ajax({
    url: url,
    type: 'GET',
    success: function(data) {
      // Replace the product list container with new HTML content
      const productListContainer = document.getElementById('product-list');
      productListContainer.innerHTML = ''; // Clear existing content
      productListContainer.insertAdjacentHTML('beforeend', data); // Insert new HTML content
    },
    error: function(error) {
      console.error('Error fetching products:', error);
    }
  });
}

let currentSortField = 'id';
let currentSortOrder = 'desc';

function sortProductsByField(field) {
  // If the clicked field is already the current sort field, change the order
  if (currentSortField === field) {
    currentSortOrder = currentSortOrder === 'asc' ? 'desc' : 'asc';
  } else {
    // Otherwise, change the sort field and reset the order to 'desc'
    currentSortField = field;
    currentSortOrder = 'desc';
  }

  // Get the current search parameters
  const searchInput = document.getElementById('search-input').value;
  const manufacturerSelect = document.getElementById('manufacturer-select').value;
  const minPrice = document.getElementById('min-price').value;
  const maxPrice = document.getElementById('max-price').value;
  const minStock = document.getElementById('min-stock').value;
  const maxStock = document.getElementById('max-stock').value;

  // Refetch the products from the server with the new sort field, order, and search parameters
  fetchProducts(searchInput, manufacturerSelect, minPrice, maxPrice, minStock, maxStock);
}

function fetchProducts(searchInput, manufacturerSelect, minPrice, maxPrice, minStock, maxStock) {
  // Build the search URL with parameters
  const searchParams = new URLSearchParams();

  // Append search parameters
  if (searchInput) {
      searchParams.append('keyword', searchInput);
  }
  if (manufacturerSelect) {
      searchParams.append('manufacturer', manufacturerSelect);
  }
  if (minPrice) {
      searchParams.append('minPrice', minPrice);
  }
  if (maxPrice) {
      searchParams.append('maxPrice', maxPrice);
  }
  if (minStock) {
      searchParams.append('minStock', minStock);
  }
  if (maxStock) {
      searchParams.append('maxStock', maxStock);
  }

  // Append sort parameters
  searchParams.append('sort', currentSortField);
  searchParams.append('order', currentSortOrder);

  const url = `http://localhost:8888/New/public/list?${searchParams.toString()}`;

  // Fetch the products from the server
  fetchProductList(url);
}

function deleteProduct(event, id) {
  event.preventDefault();  // prevent form from submitting normally

  // Change 'list' to 'products' in the URL
  $.ajax({
    url: `http://localhost:8888/New/public/products/${id}`,
    type: 'DELETE',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    success: function(data) {
      if (data.success) {
        document.querySelector(`#product-row-${id}`).remove();  // remove product row from the table
      } else {
        alert('商品の削除に失敗しました。');
      }
    },
    error: function(error) {
      console.error('Error:', error);
      alert('商品の削除に失敗しました。');
    }
  });
}

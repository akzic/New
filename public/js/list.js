'use strict';

const BASE_URL = 'http://localhost:8888/New/public';

function showDetail(productId) {
  window.location.href = `${BASE_URL}/detail/${productId}`;
}

function addProduct() {
  window.location.href = `${BASE_URL}/add/`;
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('search-button').addEventListener('click', searchProducts);
  
  document.getElementById('min-price').addEventListener('input', searchProducts);
  document.getElementById('max-price').addEventListener('input', searchProducts);
  document.getElementById('min-stock').addEventListener('input', searchProducts);
  document.getElementById('max-stock').addEventListener('input', searchProducts);
});

function searchProducts(event) {
  if (event) event.preventDefault();

  const searchParams = buildSearchParams();
  fetchProductList(`${BASE_URL}/list?${searchParams.toString()}`);
}

function fetchProductList(url) {
  $.ajax({
    url: url,
    type: 'GET',
    success: function(data) {
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
let currentSortOrder = 'asc';

function buildSearchParams() {
  const searchInput = document.getElementById('search-input').value;
  const manufacturerSelect = document.getElementById('manufacturer-select').value;
  const minPrice = document.getElementById('min-price').value;
  const maxPrice = document.getElementById('max-price').value;
  const minStock = document.getElementById('min-stock').value;
  const maxStock = document.getElementById('max-stock').value;

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

  return searchParams;
}

function deleteProduct(event, id) {
  event.preventDefault();

  if (!confirm('商品を削除しますか？')) {  // 確認ダイアログ
    return;
  }

  $.ajax({
    url: `${BASE_URL}/products/${id}`,
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
    error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error:', errorThrown);
        alert('商品の削除に失敗しました。詳細: ' + jqXHR.responseText);
    }
  });
}


function sortProductsByField(field) {
  // Update the current sort field and reverse the sort order
  currentSortField = field;
  currentSortOrder = currentSortOrder === 'desc' ? 'asc' : 'desc';

  // Trigger a new search with the updated sort parameters
  searchProducts();
}

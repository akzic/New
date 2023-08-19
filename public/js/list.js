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
  fetchProductList(`${BASE_URL}/list/search?${searchParams.toString()}`);
}

function fetchProductList(url) {
  $.ajax({
      url: url,
      type: 'GET',
      success: function(data) {
          const productListContainer = document.getElementById('product-list');
          productListContainer.innerHTML = ''; 

          if (data.products && Array.isArray(data.products)) {
              data.products.forEach(product => {
                  let productRowHtml = `
                      <tr id="product-row-${product.id}">
                          <td>${product.id}</td>
                          <td><img src="${BASE_URL}/storage/images/${product.img_path}" alt="商品画像"></td>
                          <td>${product.product_name}</td>
                          <td>${product.price}</td>
                          <td>${product.stock}</td>
                          <td>${product.company.company_name}</td>
                          <td>
                              <button onclick="showDetail('${product.id}')">詳細</button>
                          </td>
                          <td>
                              <button type="button" onclick="deleteProduct(event, ${product.id})">削除</button>
                          </td>
                      </tr>
                  `;
                  productListContainer.insertAdjacentHTML('beforeend', productRowHtml); 
              });
          } else {
              // レスポンスが想定されるJSON形式でない場合、直接テーブルコンテナに追加
              const tableContainer = document.getElementById('table-container');
              tableContainer.innerHTML = data;
          }
      },
      error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error fetching products:', errorThrown, jqXHR.responseText);
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
  
  searchParams.append('sort', currentSortField);
  searchParams.append('order', currentSortOrder);

  return searchParams;
}

function deleteProduct(event, id) {
  event.preventDefault();

  if (!confirm('商品を削除しますか？')) {
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
        document.querySelector(`#product-row-${id}`).remove();
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
  currentSortField = field;
  currentSortOrder = currentSortOrder === 'desc' ? 'asc' : 'desc';
  searchProducts();
}

$(document).ready(function() {
  $('#search-form').on('submit', function(e) {
      e.preventDefault();

      $.ajax({
          url: `${BASE_URL}/list/search`,
          type: 'POST',
          data: $(this).serialize(),
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          success: function(data) {
              $('#table-container').html(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.error('Error:', errorThrown);
              alert('検索に失敗しました。');
          }
      });
  });
});

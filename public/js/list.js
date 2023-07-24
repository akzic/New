'use strict';



function showDetail(productId)
{
  let url = 'http://localhost:8888/New/public/detail/' + productId;
  window.location.href = url;
}

function addProduct() {
  let url = 'http://localhost:8888/New/public/add/';
  window.location.href = url;
}

function searchProducts() {
  const searchInput = document.getElementById('search-input').value;
  const manufacturerSelect = document.getElementById('manufacturer-select').value;
  let url = 'http://localhost:8888/New/public/list?';

  // キーワードとメーカー名のパラメータをURLに追加
  if (searchInput) {
      url += 'keyword=' + encodeURIComponent(searchInput) + '&';
  }
  if (manufacturerSelect) {
      url += 'manufacturer=' + encodeURIComponent(manufacturerSelect);
  }

  // リダイレクト
  window.location.href = url;
}

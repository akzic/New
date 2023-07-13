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

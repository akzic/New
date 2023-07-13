'use strict';


function edit(id) {
  window.location.href = "/edit/" + id; 
}

document.getElementById('back-button').addEventListener('click', function() {
  window.location.href = "{{ route('detail', ['id' => $product->id]) }}";
});
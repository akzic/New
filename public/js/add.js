'use strict';

function submitForm(event) {
  event.preventDefault();

  const form = document.getElementById('product-form');
  const formData = new FormData(form);

  const xhr = new XMLHttpRequest();
  xhr.open('POST', form.action);
  xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
  xhr.onload = function() {
    if (xhr.status === 200) {
      console.log('Form submitted successfully');
      window.location.reload(); // ページをリロードして表示を更新
    } else {
      console.error('Form submission failed');
    }
  };
  xhr.onerror = function() {
    console.error('Form submission error');
  };
  xhr.send(formData);
}

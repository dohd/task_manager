(function () {
  "use strict";    

  const Form = document.querySelector('.php-email-form');

  const loader = Form.querySelector('.loading');
  const sentMsg = Form.querySelector('.sent-message');
  const errorMsg = Form.querySelector('.error-message');

  Form.addEventListener('submit', function (event) {
    event.preventDefault();

    loader.classList.add('d-block');
    errorMsg.classList.remove('d-block');
    sentMsg.classList.remove('d-block');

    const action = this.getAttribute('action');

    const formData = Array.from(event.target.elements).reduce((init, curr) => {
      init[curr.getAttribute('name')] = curr.value;
      return init;
    }, {});

    setTimeout(() => form_submit(this, action,formData), 2000);
  });


  function form_submit(form, action, formData) {
    fetch(action, {
      method: 'POST',
      body: JSON.stringify(formData),
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': formData._token
      }
    })
    .then(response => {
      if (response.ok) return response.json();
      else throw new Error(`${response.status} ${response.statusText} ${response.url}`);
    })
    .then(data => {
      loader.classList.remove('d-block');
      sentMsg.classList.add('d-block');
      form.reset();
    })
    .catch((error) => displayError(form, error));
  }

  function displayError(form, error) {
    loader.classList.remove('d-block');
    errorMsg.innerHTML = error;
    errorMsg.classList.add('d-block');
  }

})();



function showToast() {
  'use strict';
  var snackbarContainer = document.querySelector('#toast-text');
    'use strict';
    var data = {
      message: 'Invalid Session / Credential..',
      timeout: 2000,
      actionText: 'X',
      actionHandler: (function() {} ())
    };
    snackbarContainer.MaterialSnackbar.showSnackbar(data);
};

window.onload = showToast;


/* 
 * MIT License
 * Copyright 2020 - Godwin peter .O (me@godwin.dev)
 * Tolaram Group Nigeria
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files
 * (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish
 * distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so
 */

 
function showToast() {
  'use strict';
  var authToast = document.querySelector('#toast-text');
  var listToast = document.querySelector('#list-toast-text');

    var authToastdata = {
      message: 'Invalid Session / Credential..',
      timeout: 2000,
      actionText: 'X',
      actionHandler: (function() {} ())
    };
    
    var listToastdata = {
      message: 'No result found..',
      timeout: 5000,
      actionText: 'X',
      actionHandler: (function() {} ())
    };

    if(authToast !== null)
    {
      authToast.MaterialSnackbar.showSnackbar(authToastdata);
    }

    if(listToast !== null)
    {
      listToast.MaterialSnackbar.showSnackbar(listToastdata);
    }
};

window.onload = showToast;

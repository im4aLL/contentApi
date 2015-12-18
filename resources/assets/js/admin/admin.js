window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

jQuery(document).ready(function () {
    require('./modules/_table.js')();
});

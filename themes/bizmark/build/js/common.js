window.$ = window.jQuery = require('jquery');
require('popper.js');
require('bootstrap');
require('select2');
$(() => {
    "use strict";
    require('../../../../modules/system/assets/js/framework');
    require('../../../../modules/system/assets/js/framework.extras');
    require('../../partials/modals/request-call/request-call');

    $(function () {
        $('[data-toggle="popover"]').popover()
    })
});
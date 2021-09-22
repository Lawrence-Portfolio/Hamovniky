$(() => {
    "use strict";
    require('../../partials/property/card/gallery-slider/gallery-slider');
    require('../../partials/element/btn-like/btn-like');
    require('../../partials/property/card/yandex-map/yandex-map');

    var url = document.location.href;
    new Clipboard('.copy-link', {text: function(){ return url}});

    var w = $(document).width()
    $(window).scroll(function() {
        
        var h = $(document).scrollTop();
        if(h > 1250) {
            $('.top-page-nav').addClass('show')
        } else {
            $('.top-page-nav').removeClass('show')
        }
    })

    $(".list-link").click(function (event) {
        event.preventDefault();
        var id = $(this).attr('href');
        var offsetTop = $(id).offset().top
        if(w > 1200) {
            offsetTop = offsetTop - 75;
        } else if(w > 768) {
            offsetTop = offsetTop - 140;
        }
        $('body,html').animate({scrollTop: offsetTop}, 0);
    });
 });
 
var map = null;
var mapCenter = [55.76, 37.64]
var placemarks = []

ymaps.ready(init);

function init()
{
    $('input[name="display"]').on('click', function () {
      if($('#display-map').is(':checked')) {
         $('#yandex-map').addClass('open');
         map = new ymaps.Map('yandex-map', {
            center: mapCenter,
            zoom: 10,
            controls: ['zoomControl'],
         });

         var customBalloonLayout = ymaps.templateLayoutFactory.createClass(`
            <div class="balloon-custom-layout">
               <div class="balloon-arrow">
                  <i class="far fa-chevron-left"></i>
               </div>
               <div class="balloon-inner">
                  $[[options.contentLayout]]
               </div>
            </div>
         `, {
            build: function () {
               this.constructor.superclass.build.call(this);

               this._$element = $('.balloon-custom-layout', this.getParentElement());

               this.applyElementOffset();
            },
            applyElementOffset: function () {
               this._$element.css({
                     left: 60,
                     top: -55
               });
            }

         })

         var customClustererBalloonLayout = ymaps.templateLayoutFactory.createClass(`
            <div class="balloon-custom-layout">
               <div class="balloon-arrow">
                  <i class="far fa-chevron-left"></i>
               </div>
               <div class="balloon-inner">
                  <ul class="balloon-list">
                     {% for geoObject in properties.geoObjects %}
                     <li class="balloon-content">{{ geoObject.properties.balloonContent|raw }}</li>
                     {% endfor %}
                  </ul>
               </div>
            </div>
         `, {
            build: function () {
               this.constructor.superclass.build.call(this);
               this._$element = $('.balloon-custom-layout', this.getParentElement());
               this.applyElementOffset();
            },
            applyElementOffset: function () {
               this._$element.css({
                     left: 65,
                     top: -(this._$element[0].offsetHeight / 2 + 2)
               });
            }
         });

         var clusterer = new ymaps.Clusterer({
            clusterIconColor: '#303688',
            clusterDisableClickZoom: true,
            clusterOpenBalloonOnClick: true,
            clusterBalloonPanelMaxMapArea: 0,
            hideIconOnBalloonOpen: false,
            clusterBalloonLayout: customClustererBalloonLayout,
            clusterBalloonContantLayout: 'hello'
         });

         arCoordinates.forEach(item => {
            var link = '';
            if (item.type == 'APARTMENT') {
                link = 'properties/urban-property-rent';
            }
            else if (item.type == 'ESTATE') {
                link = 'properties/suburban-property-rent';
            }
            else if (item.type == 'COMMERCIAL') {
                link = 'properties/commercial-property-rent';
            }

            var active = '';
            for (var i=0; i<favorites.length; i++) {
                if (item.id == favorites[i]) {
                    active = 'active';
                }
            }

            var placemark = new ymaps.Placemark([item.latitude, item.longitude], {
               balloonContent: `
               <div class="balloon-item">
                  <a class="balloon-link" href="${link}/${item.slug}" target="_blank">
                     <div class="balloon-img">
                        <img class="img-fluid" src="${item.preview}">
                     </div>
                     <div class="balloon-item-wrap">
                        <div class="balloon-item-price">${parseInt(item.price).toLocaleString()} Р</div>
                        <ul class="balloon-item-specifications">
                           <li>${item.floor} этаж</li>
                           <li>${item.square} м</li>
                           <li>${item.rooms} комнаты(а)</li>
                        </ul>
                     </div>
                  </a>

               <div class="btn-like balloon-like-btn ${active}" data-value="${item.id}">
                  <i class="fas fa-heart"></i>
               </div>
               `
            }, {
               iconColor: '#151963',
               balloonLayout: customBalloonLayout,
               hideIconOnBalloonOpen: false,
            })
            placemarks.push(placemark)
         });
         clusterer.add(placemarks);
         map.geoObjects.add(clusterer);
      } else {
         map.destroy();
         map = null;
         $('#yandex-map').removeClass('open');
      }
   })

    $('body').on('click', '.balloon-like-btn', (target) => {
        target.preventDefault();

        let button = $(target.currentTarget);
        let requestName = 'Favorites::onLike';
        let itemID = button.data('value');

        if (button.hasClass('active')) {
            requestName = 'Favorites::onDislike';
        }

        $.request(requestName, {
            data: { 'itemID': itemID },
            success: function (response) {
                this.success(response);
                var attribute = button.attr('data-value');
                var currentBtn = $('.balloon-like-btn[data-value="'+attribute+'"]');

                currentBtn.toggleClass('active');
                if (currentBtn.hasClass('active')) {
                    $('.btn-like[data-value="'+attribute+'"]').addClass('active');
                }
                else {
                    $('.btn-like[data-value="'+attribute+'"]').removeClass('active');
                }
            },
            error: (response) => {
                console.log(response);
            }
        })
    })
}
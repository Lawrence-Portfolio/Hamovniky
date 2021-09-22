ymaps.ready(init);

function init() {
    var map = new ymaps.Map('yandex-map', {
        center: [55.76, 37.64],
        zoom: 10,
        controls: ['zoomControl']
    }, {
        searchControlProvider: 'yandex#search'
    })
    var mapMark = new ymaps.GeoObject({
        geometry: {
            type: "Point",
            coordinates: [arCoordinates[0].latitude, arCoordinates[0].longitude]
        }, 
    }, {
        preset: 'islands#icon',
        iconColor: '#151963',
    })
    map.geoObjects.add(mapMark)
}
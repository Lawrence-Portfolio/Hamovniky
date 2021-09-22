$(() => {
   "use strict";
   require('../../partials/property/listing/form/tabs');
   require('../../partials/property/listing/form/form');
   require('../../partials/element/btn-like/btn-like');
   require('../../partials/property/listing/yeandex-map/map');
   

   $('.custom-filter-wrap').select2({
      width: '170px',
      minimumResultsForSearch: Infinity
   });
});

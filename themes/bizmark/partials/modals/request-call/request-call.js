import 'cleave.js'
import 'cleave.js/dist/addons/cleave-phone.ru'

export default new class ModalWindow {
   constructor() {
      this.phoneMask = '[data-phone="true"]'

      this.init()
   }
   init() {
      $(this.phoneMask).toArray().forEach(function(field) {
         var cleave = new Cleave(field, {
           phone: true,
           phoneRegionCode: 'ru'
         })
       })
   }
}
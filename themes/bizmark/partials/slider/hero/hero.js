import { tns } from 'tiny-slider/src/tiny-slider';

export default new class HeroSlider {
   constructor() {
      this.heroSliderContainer ='#hero-slider',
      this.init()
   }

   init() {
      const slider = tns({
         container: `${this.heroSliderContainer}`,
         navPosition: 'bottom',
         controlsText: ['<i class="far fa-chevron-left prev-btn"></i>','<i class="far fa-chevron-right next-btn"></i>'],
         items: 1,
         autoplay: true,
     });
   }
}
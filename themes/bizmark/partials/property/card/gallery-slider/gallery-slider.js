import Splide from '@splidejs/splide'

export default new class GallerySlider {
    constructor() {
       this.gallerySlider = '.gallery-slider'
       this.gallerySliderNav = '.gallery-slider-nav'
       
       this.init();
    }
 
    init() {
        let gallerySlider = new Splide(this.gallerySlider, {
            pagination: false,
            cover: true,
            height: 485,
            lazyLoad: 'nearby',
            breakpoints: {
                '500': {
                    height: 300
                }
            }
        }).mount()

        let gallerySliderNav = new Splide(this.gallerySliderNav, {
            isNavigation: true,
            focus: 'center',
            fixedWidth: 135,
            fixedHeight: 110,
            gap: 15,
            arrows: false,
            pagination: false,
            cover: true,
            lazyLoad: 'nearby',
            breakpoints: {
                '500': {
                    fixedWidth: 100,
                    fixedHeight: 70
                }
            }
        }).mount()
        gallerySlider.sync( gallerySliderNav ).mount();
    }
 }
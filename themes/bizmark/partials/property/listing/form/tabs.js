export default new class Tabs {
    constructor() {
        this.tabs = '.tabs'

        this.animalsAndKids = '.animals-and-kids'

        this.init()
    }

    init() {
        const self = this

        $(this.tabs).find('.tab').on('click', function () {
            self.checkState($(this))
        })
    }
    checkState(elem) {
        let id = elem.attr('id')

        if(id == 'sale-tab') {
            $(this.tabs).find('#sale-tab').addClass('active')
            $(this.tabs).find('#rent-tab').removeClass('active')
            $(this.animalsAndKids).css({ display: 'none' })
        } else if(id = 'rent-tab') {
            $(this.tabs).find('#sale-tab').removeClass('active')
            $(this.tabs).find('#rent-tab').addClass('active')
            $(this.animalsAndKids).css({ display: 'block' })
        }
    }
}
import UrlGeneration from '@lovata/url-generation';
export default new(class ArticlesListing {
    constructor()
    {
        this.radioButton = 'input[name="filter"]';
        this.postsWrap = '#postsWrap';
        this.xhr = null;

        this.init();
    }

    init()
    {
        $(`${this.radioButton}`).on('change', (target) => {
            target.preventDefault();

            if (this.xhr) {
                this.xhr.abort();
            }

            let button = $(target.currentTarget);

            UrlGeneration.init();
            UrlGeneration.clear();
            UrlGeneration.set('filter', button.val());
            UrlGeneration.update();

            this.xhr = $.request('onAjax', {
                update: {
                    'posts/default' : `${this.postsWrap}`
                }
            })
        });
    }
})();

export default new class BtnLike {
    constructor() {
        this.btnLike = '.btn-like';
        this.init();
    }

    init() {
        $(this.btnLike).on('click', (target) => {
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
                    var currentBtn = $('.btn-like[data-value="'+attribute+'"]');
                    currentBtn.toggleClass('active');
                    if (currentBtn.hasClass('active')) {
                        $('.balloon-like-btn[data-value="'+attribute+'"]').addClass('active');
                    }
                    else {
                        $('.balloon-like-btn[data-value="'+attribute+'"]').removeClass('active');
                    }

                },
                error: (response) => {
                    console.log(response);
                }
            })
        })
    }
 }



(function ($, root, undefined) {
    $('.slider').slick({
        autoplay: true,
        speed: 800,
        lazyLoad: 'progressive',
        arrows: false,
        dots: false,
        prevArrow: '<div class="slick-nav prev-arrow"><i></i><svg><use xlink:href="#circle"></svg></div>',
        nextArrow: '<div class="slick-nav next-arrow"><i></i><svg><use xlink:href="#circle"></svg></div>',
    }).slickAnimation();



    $('.slick-nav').on('click touch', function(e) {

        e.preventDefault();

        let arrow = $(this);

        if(!arrow.hasClass('animate')) {
            arrow.addClass('animate');
            setTimeout(() => {
                arrow.removeClass('animate');
            }, 1600);
        }

    });
})(jQuery);
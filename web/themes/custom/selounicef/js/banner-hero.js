(function ($) {
    Drupal.behaviors.bannerHeroSlider = {
        attach: function (context, settings) {
            $('.banner-hero-slider', context).once('bannerHeroSlider').each(function () {
                $(this).slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    prevArrow: $('.banner-hero-prev'),
                    nextArrow: $('.banner-hero-next')
                });
            });
        }
    };
})(jQuery);
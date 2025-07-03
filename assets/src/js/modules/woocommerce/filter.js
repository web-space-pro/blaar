//Фильтр на странице магазина
jQuery(document).ready(function($) {
    let filters = $('#product-filters');
    let button = $('#show-filters');
    let closeButton = $('#close-filters');

    button.on('click', function(event) {
        event.preventDefault();
        filters.stop().fadeToggle(300);
        $('body').toggleClass('ov-hidden');
    });

    closeButton.on('click', function() {
        filters.fadeOut(300);
        $('body').removeClass('ov-hidden');
    });

    $(document).on('click', function(event) {
        if (!filters.is(event.target) && filters.has(event.target).length === 0 &&
            !button.is(event.target) && button.has(event.target).length === 0) {
            filters.fadeOut(300);
            $('body').removeClass('ov-hidden');
        }
    });
});
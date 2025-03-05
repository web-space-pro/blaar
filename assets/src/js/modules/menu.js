(function ($, root, undefined) {
    $(document).ready(function(){
        $('.btn-burger').click(function(e){
            $('.btn-burger, .mobile-menu').toggleClass('toggled');
        });
    });
})(jQuery);


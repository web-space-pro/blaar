(function ($, root, undefined) {
    $(document).ready(function(){
        $('#nav-icon').click(function(){
            $(this).toggleClass('open');
            $('.tcontainer').toggleClass('open');

        });
    });
})(jQuery);


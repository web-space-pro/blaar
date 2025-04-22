
jQuery(function ($) {
   const inputNames = ['billing_phone', 'shipping_phone', 'user_phone', 'targetvr_billing_phone'];;

    if ($.fn.mask) { // Проверяем, загружен ли плагин
        inputNames.forEach(function (name) {
            $('input[name="' + name + '"]').each(function () {
                $(this).mask('+7 (999) 999-99-99', {
                    placeholder: '+7 (___) ___-__-__'
                });
            });
        });
    } else {
        console.error("jQuery Mask Plugin не загружен!");
    }
});
jQuery(document).ready(function ($) {

 /* ***********************************************************
    этот кусок кода отвечает за вывод доп. изображения в loop
    и вывод доп.изображение при переключении вариаций
 */
    function updateVariationImage(variation, productWrapper) {
        let productImageWrapper = productWrapper.find('.cfvsw-original-thumbnail img');

        if (variation && variation.woo_variation_gallery_images && variation.woo_variation_gallery_images.length > 0) {
            let firstVariationImage = variation.woo_variation_gallery_images[0];
            productImageWrapper.attr('src', firstVariationImage);
            productImageWrapper.attr('srcset', firstVariationImage);
        }
    }

    // Отслеживаем смену вариации в cfvsw_variations_form
    $(document).on('found_variation', '.cfvsw_variations_form', function (event, variation) {
        let productWrapper = $(this).closest('.product');
        updateVariationImage(variation, productWrapper);
    });

    // Обновляем изображение при загрузке страницы, если вариация выбрана по умолчанию
    $('.cfvsw_variations_form').each(function () {
        let form = $(this);
        let productWrapper = form.closest('.product');
        let selectedVariation = form.data('product_variations');

        if (selectedVariation) {
            let activeVariation = selectedVariation.find(variation => variation.is_in_stock && variation.display_price);
            if (activeVariation) {
                updateVariationImage(activeVariation, productWrapper);
            }
        }
    });

/* ******** конец кода ********/
});
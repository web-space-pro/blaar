jQuery(document).ready(function($) {
    $('form.variations_form').on('change', 'select, .swatch-wrapper', function() {
        setTimeout(function() {
            let variationId = $('input.variation_id').val(); // ID выбранной вариации

            if (variationId && variationImages[variationId]) {
                $('#main-product-image').attr('src', variationImages[variationId].image);

                let galleryContainer = $('#product-gallery-thumbs');
                galleryContainer.empty();

                variationImages[variationId].gallery.forEach(function(imgUrl) {
                    galleryContainer.append('<img src="' + imgUrl + '" class="gallery-thumb" />');
                });
            }
        }, 100);
    });
});


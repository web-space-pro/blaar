function updateCartCount() {
    fetch('/wp-admin/admin-ajax.php?action=blaar_get_cart_count')
        .then(response => response.text())
        .then(count => {
            const cartCountElements = document.querySelectorAll(".cart-total");
            cartCountElements.forEach(el => {
                el.textContent = count;
            });
        })
        .catch(console.error);
}

jQuery(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
    const productId = $button?.data('product_id');
    if (productId) {
        updateCartCount();
    }

    // Показать уведомление, если оно пришло
    fetch('/wp-admin/admin-ajax.php?action=get_wc_notices')
        .then(response => response.json())
        .then(data => {
            if (data.success && data.data.html) {
                const wrapper = document.querySelector('.woocommerce-notices-wrapper');
                if (wrapper) {
                    wrapper.innerHTML = data.data.html;
                } else {
                    const newWrapper = document.createElement('div');
                    newWrapper.className = 'woocommerce-notices-wrapper';
                    newWrapper.innerHTML = data.data.html;
                    document.body.prepend(newWrapper);
                }
            }
        })
        .catch(console.error);

});

jQuery(document).ready(function ($) {

 /* ***********************************************************
    этот кусок кода отвечает за вывод доп. изображения в loop
    и вывод доп.изображение при переключении вариаций
 */
    function updateVariationImage(variation, productWrapper) {
        let productImageWrapper = productWrapper.find('.cfvsw-original-thumbnail img');
        if (variation && variation.vargal_params && variation.vargal_params.length > 0) {
            // console.log(variation.vargal_params[0]);
            let firstVariationImage = variation.vargal_params[0];
            productImageWrapper.attr('src', firstVariationImage);
            productImageWrapper.attr('srcset', firstVariationImage);
        }else{
            setTimeout(() => {
                let imgOrig = productWrapper.find('.woocommerce-LoopProduct-link > img');
                productImageWrapper.attr('src', imgOrig[0].currentSrc);
                productImageWrapper.attr('srcset', imgOrig[0].currentSrc);
            }, 200);

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


//вывод только 3-ох цветов товара (+N)
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        const productCards = document.querySelectorAll(".products-list li");

        productCards.forEach(card => {
            const swatchContainer = card.querySelector(".cfvsw-swatches-container");
            if (!swatchContainer) return;

            const swatches = swatchContainer.querySelectorAll(".cfvsw-swatches-option");

            if (swatches.length <= 3) return;

            // Скрыть все кроме первых 3
            swatches.forEach((el, index) => {
                if (index >= 3) el.style.display = "none";
            });

            // Создать блок "+N"
            const hiddenCount = swatches.length - 3;
            const moreBlock = document.createElement("div");
            moreBlock.className = "cfvsw-swatches-more";
            moreBlock.textContent = `+${hiddenCount}`;

            // При клике — переход на страницу товара
            const productLink = card.querySelector(".woocommerce-LoopProduct-link");
            if (productLink) {
                moreBlock.addEventListener("click", () => {
                    window.location.href = productLink.href;
                });
            }

            swatchContainer.insertAdjacentElement('afterend', moreBlock);
        });
    }, 100);

});
document.addEventListener("DOMContentLoaded", function () {
    updateCartCount();
    initProductActions();
    initCategoryFilter();
});

function updateCartCount() {
    fetch('/wp-admin/admin-ajax.php?action=blaar_get_cart_count')
        .then(response => response.text())
        .then(count => {
            document.getElementById('cart-count').textContent = count;
        })
        .catch(console.error);
}

function getCartQuantity(productId, callback) {
    fetch(`/wp-admin/admin-ajax.php?action=blaar_get_cart_quantity&product_id=${productId}`)
        .then(response => response.json())
        .then(data => {
            callback(data.quantity || 0);
        })
        .catch(() => callback(0));
}

function updateProductUI(productId, quantity) {
    jQuery(function ($) {
        $('.product-actions[data-product-id="' + productId + '"]').each(function () {
            const wrapper = $(this);
            const qtyInput = wrapper.find('.qty');
            const addToCartBtn = wrapper.find('.ajax_add_to_cart');
            const qtyWrapper = wrapper.find('.quantity-wrapper');


            if (quantity > 0) {
                addToCartBtn.hide().removeClass('loading');
                qtyWrapper.removeClass('hidden-quantity');
                qtyInput.val(quantity);
            } else {
                addToCartBtn.show().removeClass('loading');
                qtyWrapper.addClass('hidden-quantity');
                qtyInput.val(0);
            }
        });
    });
}

function initProductActions() {
    jQuery(function ($) {
        $('.product-actions').each(function () {
            const wrapper = $(this);
            const qtyInput = wrapper.find('.qty');
            const plus = wrapper.find('.qty-plus');
            const minus = wrapper.find('.qty-minus');
            const productId = wrapper.data('product-id');

            function updateCart(quantity) {
                $.post(wc_add_to_cart_params.ajax_url, {
                    action: 'blaar_update_cart_quantity',
                    product_id: productId,
                    quantity: quantity,
                }).done(() => {
                    $(document.body).trigger('wc_fragment_refresh');
                    updateCartCount();
                    updateProductUI(productId, quantity);
                });
            }

            function changeQuantity(delta) {
                let currentQty = parseInt(qtyInput.val()) || 0;
                const newQty = Math.max(0, currentQty + delta);
                qtyInput.val(newQty);
                updateCart(newQty);
            }

            getCartQuantity(productId, quantity => updateProductUI(productId, quantity));

            plus.off('click').on('click', () => changeQuantity(1));
            minus.off('click').on('click', () => changeQuantity(-1));
        });

        $(document.body).off('added_to_cart').on('added_to_cart', function (event, fragments, cart_hash, button) {
            const productId = button.data('product_id');
            if (productId) {
                updateProductUI(productId, 1);
            }
            updateCartCount();
        });
    });
}

function initCategoryFilter() {
    const categoryWrap = document.querySelector('.filter-product');
    if (!categoryWrap) return;

    const filterButtons = categoryWrap.querySelectorAll("[data-id]");
    const productsContainer = document.getElementById("products-list");
    const pageID = document.body.dataset.pageId;

    filterButtons.forEach(button => {
        button.addEventListener("click", function () {
            let categoryId = this.getAttribute("data-id");
            filterButtons.forEach(btn => btn.classList.remove("active"));
            this.classList.add("active");
            productsContainer.innerHTML = '<div class="m-auto col-span-2 lg:col-span-3 loadingspinner"></div>';

            fetch(ajaxurl, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    action: "blaar_filter_products_by_category",
                    category_id: categoryId,
                    page_id: pageID
                }),
            })
                .then(response => response.text())
                .then(data => {
                    productsContainer.innerHTML = data;
                    initProductActions();
                })
                .catch(error => {
                    console.error("Ошибка:", error);
                    productsContainer.innerHTML = '<p class="error">Ошибка загрузки</p>';
                });
        });
    });
}
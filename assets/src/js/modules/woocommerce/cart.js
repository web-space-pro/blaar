//Тут вся AJAX - логика карты + чекаута
document.addEventListener("DOMContentLoaded", function () {
    let updateTimeout;
    let abortController = new AbortController();
    let isUpdating = false;

    function setLoadingState(el, loading = true) {
        if (loading) el.classList.add('loading');
        else el.classList.remove('loading');
    }

    document.body.addEventListener("click", function (event) {
        let button = event.target.closest(".qty-minus, .qty-plus");
        if (!button) return;

        let wrapper = button.closest(".quantity-wrapper");
        let input = wrapper.querySelector(".qty");
        let currentValue = parseInt(input.value);
        let min = parseInt(input.getAttribute("min")) || 1;
        let max = parseInt(input.getAttribute("max")) || 100;
        let newValue = currentValue;

        if (button.classList.contains("qty-plus") && currentValue < max) {
            newValue++;
        } else if (button.classList.contains("qty-minus") && currentValue > min) {
            newValue--;
        }

        input.value = newValue;

        abortController.abort();
        abortController = new AbortController();
        clearTimeout(updateTimeout);

        updateTimeout = setTimeout(() => {
            updateCart(input, newValue, abortController.signal);
        }, 300);
    });

    document.body.addEventListener("click", function (event) {
        let removeButton = event.target.closest(".product-remove a");
        if (!removeButton) return;

        event.preventDefault();

        let cartItemRow = removeButton.closest(".cart_item");
        if (!cartItemRow) return;

        let quantityInput = cartItemRow.querySelector(".qty");

        abortController.abort();
        abortController = new AbortController();

        updateCart(quantityInput, 0, abortController.signal);
    });

    async function updateCart(input, quantity, signal) {
        if (isUpdating) return;
        isUpdating = true;


        let inputName = input.getAttribute("name");
        let match = inputName.match(/cart\[([a-f0-9]+)\]\[qty\]/);
        if (!match || !match[1]) {
            console.error("Не удалось получить hash товара:", inputName);
            isUpdating = false;
            return;
        }

        let itemHash = match[1];
        showCartSpinner(true);
        setLoadingState(input, true);

        try {
            let response = await fetch("/wp-admin/admin-ajax.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    action: "blaar_update_cart_ajax",
                    hash: itemHash,
                    quantity: quantity
                }),
                signal
            });

            let data = await response.json();

            if (data.success) {
                const row = input.closest(".cart_item");

                if (data.data.item_removed && row) {
                    row.remove();
                } else {
                    if (row && data.data.item_total_html) {
                        row.querySelector(".product-subtotal").innerHTML = data.data.item_total_html;
                    }
                    input.value = quantity;
                }

                // Обновляем частичные блоки
                // document.querySelector(".cart_totals").innerHTML = data.data.cart_totals_html;
                document.querySelector(".woocommerce-checkout-review-order-table").innerHTML = data.data.checkout_review_html;
                document.querySelector("#order-total-cart").innerHTML = data.data.order_total;

                updateCartCount(data.data.cart_count);

                if (data.data.cart_count === 0) {
                    document.querySelector(".shop_table.cart").innerHTML = '<tr><td colspan="6">Ваша корзина пуста</td></tr>';
                }
            } else {
                console.error("Ошибка обновления корзины:", data.message);
            }
        } catch (error) {
            if (error.name !== "AbortError") {
                console.error("Ошибка запроса:", error);
            }
        } finally {
            setLoadingState(input, false);
            showCartSpinner(false);
            isUpdating = false;
        }
    }

    function showCartSpinner(show = true) {
        const spinner = document.getElementById("cart-spinner");
        if (spinner) {
            spinner.style.display = show ? "flex" : "none";
        }
    }

    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll(".cart-total");
        cartCountElements.forEach(el => {
            el.textContent = count;
        });
    }
});


// Пригающий Label в формах
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".form-row input").forEach((input) => {
        const formRow = input.closest(".form-row");
        const label = formRow ? formRow.querySelector("label") : null;

        if (label) {
            // Добавляем класс active при фокусе
            input.addEventListener("focus", function () {
                label.classList.add("active");
            });

            // Убираем класс, если поле пустое при потере фокуса
            input.addEventListener("blur", function () {
                if (!input.value.trim()) {
                    label.classList.remove("active");
                }
            });

            // Если поле уже заполнено (например, после автозаполнения)
            if (input.value.trim()) {
                label.classList.add("active");
            }
        }
    });
});
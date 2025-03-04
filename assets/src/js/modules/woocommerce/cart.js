document.addEventListener("DOMContentLoaded", function () {
    if (!document.body.classList.contains("woocommerce-cart")) return;
    let updateTimeout;
    let abortController = new AbortController();

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

        // Отменяем предыдущий AJAX-запрос перед отправкой нового
        abortController.abort();
        abortController = new AbortController();

        clearTimeout(updateTimeout);
        updateTimeout = setTimeout(() => updateCart(input, newValue, abortController.signal), 300);
    });

    async function updateCart(input, quantity, signal) {
        let inputName = input.getAttribute("name");
        let match = inputName.match(/cart\[([a-f0-9]+)\]\[qty\]/);
        if (!match || !match[1]) {
            console.error("Не удалось получить hash товара:", inputName);
            return;
        }

        let itemHash = match[1];

        try {
            let response = await fetch("/wp-admin/admin-ajax.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    action: "update_cart_ajax",
                    hash: itemHash,
                    quantity: quantity
                }),
                signal
            });

            let data = await response.json();

            if (data.success) {
                const cartTable = document.querySelector(".shop_table.cart");
                if (cartTable) {
                    cartTable.innerHTML = new DOMParser()
                        .parseFromString(data.data.cart_html, "text/html")
                        .querySelector(".shop_table.cart").innerHTML;
                }

                // Обновляем счётчик корзины, если сервер вернул его в ответе
                if (data.data.cart_count !== undefined) {
                    updateCartCount(data.data.cart_count);
                }

                $('button[name="update_cart"]').click();
            } else {
                console.error("Ошибка обновления корзины:", data.message);
            }
        } catch (error) {
            if (error.name !== "AbortError") {
                console.error("Ошибка запроса:", error);
            }
        }
    }

    function updateCartCount(count) {
        document.getElementById("cart-count").textContent = count;
    }
});
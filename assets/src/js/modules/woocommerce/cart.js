//Тут вся AJAX - логика карты + чекаута
document.addEventListener("DOMContentLoaded", function () {
    let updateTimeout;
    let abortController = new AbortController();

    // Обработчик клика для кнопок изменения количества товара
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

    // Обработчик для кнопок удаления товара
    document.body.addEventListener("click", function (event) {
        let removeButton = event.target.closest(".product-remove a"); // Находим кнопку удаления
        if (!removeButton) return;

        event.preventDefault();  // Предотвращаем переход по ссылке



        // Получаем строку товара
        let cartItemRow = removeButton.closest(".cart_item");
        if (!cartItemRow) return;



        // Получаем ID товара из data-атрибута
        let itemId = removeButton.getAttribute("data-product_id");
        if (!itemId) return;
        console.log(itemId);

        //Устанавливаем новое количество (если товар удаляется, количество будет 0)
         let quantityInput = cartItemRow.querySelector(".qty");

        // Отменяем предыдущий AJAX-запрос перед отправкой нового
        abortController.abort();
        abortController = new AbortController();

        // Отправляем запрос на обновление корзины с количеством 0
        updateCart(quantityInput, 0, abortController.signal); // Устанавливаем 0, чтобы удалить товар из корзины
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
            let response = await fetch(ajaxurl, {
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
               if(data.data.cart_count != 0){
                   const cartTable = document.querySelector(".shop_table.cart");
                   if (cartTable) {
                       cartTable.innerHTML = new DOMParser()
                           .parseFromString(data.data.cart_html, "text/html")
                           .querySelector(".shop_table.cart").innerHTML;
                   }
               }

                const checkoutReviewTable = document.querySelector(".woocommerce-checkout-review-order-table");
                if (checkoutReviewTable) {
                    checkoutReviewTable.innerHTML = new DOMParser()
                        .parseFromString(data.data.checkout_review_html, "text/html")
                        .querySelector(".woocommerce-checkout-review-order-table").innerHTML;
                }

                // Обновляем сумму заказов в корзине
                const cartCollaterals = document.querySelector(".cart_totals");
                if (cartCollaterals) {
                    cartCollaterals.innerHTML = new DOMParser()
                        .parseFromString(data.data.cart_collaterals_html, "text/html")
                        .querySelector(".cart_totals").innerHTML;
                }

                // Обновляем итоговую сумму заказа
                const orderTotalElement = document.querySelector("#order-total-cart");
                if (orderTotalElement) {
                    orderTotalElement.innerHTML = data.data.order_total;
                }

                // Обновляем счётчик корзины
                if (data.data.cart_count !== undefined) {
                    updateCartCount(data.data.cart_count);
                }

                // Если количество товаров 0, выполняем перезагрузку
                if (data.data.cart_count === 0) {
                    window.location.reload();
                }

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
        const cartCountElement = document.getElementById("cart-total");
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
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









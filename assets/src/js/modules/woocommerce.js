document.addEventListener("DOMContentLoaded", function () {
    updateCartCount(); // Обновляем при загрузке страницы

    // Обновляем счётчик при добавлении товара в корзину
    document.body.addEventListener("added_to_cart", updateCartCount);

    // Следим за кликами на кнопки "Добавить в корзину"
    document.body.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('add_to_cart_button') || event.target.classList.contains('ajax_add_to_cart')) {
            // Немедленно увеличиваем счётчик на 1
            let currentCount = parseInt(document.getElementById('cart-count').textContent) || 0;
            document.getElementById('cart-count').textContent = currentCount + 1;

            // Отправляем запрос на обновление корзины (через AJAX)
            updateCartCount();
        }
    });
});

function updateCartCount() {
    fetch('/wp-admin/admin-ajax.php?action=blaar_get_cart_count')
        .then(response => response.text())  // Получаем текст (количество товаров)
        .then(count => {
            // Обновляем текст в элементе с id 'cart-count'
            document.getElementById('cart-count').textContent = count;
        })
        .catch(console.error);
}



document.addEventListener("DOMContentLoaded", function () {
    // Находим все ссылки на страницы товаров
    const productLinks = document.querySelectorAll('.woocommerce-loop-product__link');

    productLinks.forEach(function(link) {
        // Добавляем обработчик клика для каждой ссылки
        link.addEventListener('click', function(event) {
            event.preventDefault(); // Отменяет переход по ссылке
            console.log('Переход по ссылке товара заблокирован');
        });
    });
});
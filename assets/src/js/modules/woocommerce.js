require("./woocommerce/loop");
require("./woocommerce/cart");

document.addEventListener('DOMContentLoaded', function () {
    let noticesWrapper = document.querySelector('.woocommerce-notices-wrapper');

    if (noticesWrapper) {
        // Изначально скрываем блок

        // Показываем блок, если он содержит сообщения
        if (noticesWrapper.innerHTML.trim() !== '') {
            setTimeout(() => {
                noticesWrapper.style.opacity = '1';
                noticesWrapper.style.visibility = 'visible';
                noticesWrapper.style.transform = 'translateY(0)';
                noticesWrapper.style.height = 'auto';

                // Скрываем через 3 секунды
                setTimeout(() => {
                    noticesWrapper.style.opacity = '0';
                    noticesWrapper.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        noticesWrapper.style.visibility = 'hidden';
                    }, 500);
                }, 3000);
            }, 100);
        }
    }
});









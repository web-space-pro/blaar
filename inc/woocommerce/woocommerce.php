<?php
// Настройка WooCommerce
add_action( 'after_setup_theme', 'blaar_wooc_theme_setup' );


//Удаление всех стилей WooCommerce
add_action('wp_enqueue_scripts', 'blaar_dequeue_woocommerce_styles', 99);


function blaar_wooc_theme_setup() {


    // Включает поддержку WooCommerce в теме
    add_theme_support('woocommerce');

    // Включает поддержку изображений товаров разного размера
    add_theme_support('wc-product-gallery-zoom'); // Зум картинок товаров
    add_theme_support('wc-product-gallery-lightbox'); // Лайтбокс для изображений
    add_theme_support('wc-product-gallery-slider'); // Слайдер изображений товаров


}

function blaar_dequeue_woocommerce_styles() {
//    if (class_exists('WooCommerce')) {
//        // Удаляем все стандартные стили WooCommerce
//        wp_dequeue_style('woocommerce-general');  // Основные стили
//        wp_dequeue_style('woocommerce-layout');   // Стили разметки
//        wp_dequeue_style('woocommerce-smallscreen'); // Стили для мобильных устройств
//    }

    if (!is_cart() && !is_checkout() && !is_account_page()) {
        wp_dequeue_style('woocommerce-general');
        wp_dequeue_style('woocommerce-layout');
        wp_dequeue_style('woocommerce-smallscreen');
    }
}



require 'woocommerce-ajax.php';
require 'woocommerce-archive.php';
require 'woocommerce-single-product.php';

?>
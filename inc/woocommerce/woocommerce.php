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


/* -------Global Functions------*/

//Добавляем скидку рядом с ценой
//Фильтр для изменения вывода цены
add_filter('woocommerce_get_price_html', 'blaar_custom_price_display', 100, 2);
function blaar_custom_price_display($price_html, $product) {
    if ($product->is_type('variable')) {
        return $price_html;
    }
    $regular_price = $product->get_regular_price();
    $sale_price = $product->get_sale_price();

    if ($sale_price && $regular_price > $sale_price) {
        $discount_percent = round((($regular_price - $sale_price) / $regular_price) * 100);
        $price_html = "<span class='sale-price'>" . wc_price($sale_price) . "</span> 
            <span class='discount-percent'>-{$discount_percent}%</span> 
            <span class='regular-price'>" . wc_price($regular_price) . "</span>";
    }

    return $price_html;
}


//скрыть ссылку "Главная" из хлебных крошек
function remove_home_from_breadcrumbs($defaults) {
    $defaults['home'] = ''; // Убираем название главной страницы
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'remove_home_from_breadcrumbs');

function custom_woocommerce_breadcrumb_separator($defaults) {
    $defaults['delimiter'] = ' > '; // Измените на нужный символ или HTML
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumb_separator');

// Удаляет последний элемент из массива хлебных крошек
function remove_last_breadcrumb_item($crumbs) {
    if (!empty($crumbs)) {
        array_pop($crumbs);
    }
    return $crumbs;
}
add_filter('woocommerce_get_breadcrumb', 'remove_last_breadcrumb_item');

//изменить заголовок "Related Products"
add_filter('woocommerce_product_related_products_heading', function () {
    return 'Вам может понравиться';
});




/* -------File------*/
require 'woocommerce-archive.php';
require 'woocommerce-single-product.php';

//require 'woocommerce-ajax.php';













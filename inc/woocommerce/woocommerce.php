<?php
// Настройка WooCommerce
add_action( 'after_setup_theme', 'blaar_wooc_theme_setup' );

//Удаление всех стилей WooCommerce
add_action('wp_enqueue_scripts', 'blaar_dequeue_woocommerce_styles', 99);
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_style('woocommerce-general'); // Основные стили
    wp_dequeue_style('woocommerce-layout');  // Стили разметки
    wp_dequeue_style('woocommerce-smallscreen'); // Стили для мобильных устройств
}, 99);


//удалить оберку страници (делаем свою)
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

//Удаление хлебных крошек
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

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
add_filter( 'woocommerce_get_price_html', 'blaar_insert_discount_between_del_and_ins', 20, 2 );
function blaar_insert_discount_between_del_and_ins( $price_html, $product ) {
    if ( is_shop() || is_product_category() || is_product_tag() || is_product() ) {

        // Для вариативного товара
        if ( $product->is_type('variable') ) {
            $variations = $product->get_available_variations();
            $regular_prices = [];
            $sale_prices = [];

            foreach ( $variations as $variation_data ) {
                $variation = wc_get_product( $variation_data['variation_id'] );
                $reg_price = (float) $variation->get_regular_price();
                $sale_p    = (float) $variation->get_sale_price();

                if ( $reg_price > 0 ) {
                    $regular_prices[] = $reg_price;
                    $sale_prices[] = $sale_p;
                }
            }

            // Все цены одинаковые
            if ( !empty($regular_prices) && count(array_unique($regular_prices)) === 1 && count(array_unique($sale_prices)) === 1 ) {
                $regular_price = $regular_prices[0];
                $sale_price    = $sale_prices[0];

                if ( $sale_price && $regular_price > $sale_price ) {
                    $discount_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                    $discount_html = ' <span class="price-discount">' . $discount_percent . '%</span> ';

                    $price_html = '<del>' . wc_price($regular_price) . '</del> <ins>' . wc_price($sale_price) . '</ins>' . $discount_html;
                } else {
                    $price_html = '<ins>' . wc_price($regular_price) . '</ins>';
                }

                return $price_html;
            } else {
                // Если цены разные — оставить оригинальное поведение WooCommerce
                return $price_html;
            }
        }

        // Обычные товары
        $regular_price = (float) $product->get_regular_price();
        $sale_price    = (float) $product->get_sale_price();

        if ( $sale_price && $regular_price > $sale_price ) {
            $discount_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
            $discount_html = ' <span class="price-discount">' . $discount_percent . '%</span> ';

            // Вставка после </del>
            $price_html = preg_replace(
                '/<\/del>(\s*)<span class="screen-reader-text">/',
                '</del>' . $discount_html . '<span class="screen-reader-text">',
                $price_html
            );
        }
    }

    return $price_html;
}
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );




//скрыть ссылку "Главная" из хлебных крошек
function remove_home_from_breadcrumbs($defaults) {
    $defaults['home'] = '';
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'remove_home_from_breadcrumbs');

function custom_woocommerce_breadcrumb_separator($defaults) {
    $defaults['delimiter'] = ' > ';
    return $defaults;
}
add_filter('woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumb_separator');

 //Удаляет последний элемент из массива хлебных крошек
function remove_last_breadcrumb_item($crumbs) {
    if (is_product() && is_array($crumbs) && !empty($crumbs)) {
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
require 'woocommerce-cart.php';
require 'woocommerce-checkout.php';
require 'woocommerce-my-account.php';
require 'woocommerce-ajax.php';


















<?php
//динамическое обновление количество товаров  в header
add_action('wp_ajax_blaar_get_cart_count', 'blaar_get_cart_count');
add_action('wp_ajax_nopriv_blaar_get_cart_count', 'blaar_get_cart_count');



function blaar_get_cart_count() {
    if (WC()->cart) {
        echo WC()->cart->get_cart_contents_count();
    } else {
        echo 0;
    }
    wp_die();
}
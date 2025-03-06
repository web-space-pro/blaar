<?php


add_filter('woocommerce_get_item_data', function ($item_data, $cart_item) {
    return []; // Полностью убираем метаданные
}, 10, 2);
//function enable_cart_fragments() {
//    if (is_cart()) {
//        wp_enqueue_script('wc-cart-fragments');
//    }
//}
//add_action('wp_enqueue_scripts', 'enable_cart_fragments');

function update_cart_ajax() {
    if (!isset($_POST['hash']) || !isset($_POST['quantity'])) {
        wp_send_json_error(['message' => 'Invalid data']);
    }

    $cart = WC()->cart;
    $hash = sanitize_text_field($_POST['hash']);
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        $cart->remove_cart_item($hash);
    } else {
        $cart->set_quantity($hash, $quantity, true);
    }

    WC()->cart->calculate_totals();
    WC()->cart->maybe_set_cart_cookies();

    ob_start();
    wc_get_template('cart/cart.php'); // Загружаем шаблон корзины
    $cart_html = ob_get_clean();

    wp_send_json_success([
        'cart_html'  => $cart_html,
        'cart_count' => WC()->cart->get_cart_contents_count(),
    ]);
}
add_action('wp_ajax_update_cart_ajax', 'update_cart_ajax');
add_action('wp_ajax_nopriv_update_cart_ajax', 'update_cart_ajax');















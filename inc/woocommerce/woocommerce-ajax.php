<?php
//динамическое обновление количество товаров  в header
add_action('wp_ajax_blaar_get_cart_count', 'blaar_get_cart_count');
add_action('wp_ajax_nopriv_blaar_get_cart_count', 'blaar_get_cart_count');

//cart update
add_action('wp_ajax_blaar_update_cart_ajax', 'blaar_update_cart_ajax');
add_action('wp_ajax_nopriv_blaar_update_cart_ajax', 'blaar_update_cart_ajax');

add_action('wp_ajax_get_wc_notices', 'blaar_get_wc_notices');
add_action('wp_ajax_nopriv_get_wc_notices', 'blaar_get_wc_notices');

function blaar_get_wc_notices() {
    ob_start();
    wc_print_notices();
    $notices = ob_get_clean();

    // Очистить после первого показа
    WC()->session->set('wc_notices', []);

    wp_send_json_success(['html' => $notices]);
}


function blaar_get_cart_count() {
    if (WC()->cart) {
        echo WC()->cart->get_cart_contents_count();
    } else {
        echo 0;
    }
    wp_die();
}
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    //Обновлнеие количество товаров
    ob_start();
    ?>
    <span class="align-text-bottom cart-total"> <?php echo WC()->cart->get_cart_contents_count(); ?></span>
    <?php
    $fragments['.cart-total'] = ob_get_clean();

    return $fragments;
});


function blaar_update_cart_ajax() {
    if (!isset($_POST['hash'], $_POST['quantity'])) {
        wp_send_json_error(['message' => 'Неверные данные']);
    }

    $hash = sanitize_text_field($_POST['hash']);
    $quantity = intval($_POST['quantity']);

    $cart = WC()->cart;

    $item_removed = false;

    if ($quantity <= 0) {
        $cart->remove_cart_item($hash);
        $item_removed = true;
    } else {
        $cart->set_quantity($hash, $quantity, true);
    }

    $cart->calculate_totals();
    $cart->maybe_set_cart_cookies();

    $item_total_html = '';
    if (!$item_removed && ($item = $cart->get_cart_item($hash))) {
        $item_total_html = wc_price($item['line_total'] + $item['line_tax']);
    }

    ob_start();
    wc_get_template('cart/cart-totals.php');
    $cart_totals_html = ob_get_clean();

    ob_start();
    wc_get_template('checkout/review-order.php');
    $checkout_review_html = ob_get_clean();

    wp_send_json_success([
        'item_removed'           => $item_removed,
        'item_total_html'        => $item_total_html,
        'cart_totals_html'       => $cart_totals_html,
        'checkout_review_html'   => $checkout_review_html,
        'cart_count'             => $cart->get_cart_contents_count(),
        'order_total'            => wc_price($cart->get_total('raw')),
    ]);
}
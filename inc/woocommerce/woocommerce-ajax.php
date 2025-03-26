<?php
//динамическое обновление количество товаров  в header
//add_action('wp_ajax_blaar_get_cart_count', 'blaar_get_cart_count');
//add_action('wp_ajax_nopriv_blaar_get_cart_count', 'blaar_get_cart_count');

//cart update
add_action('wp_ajax_update_cart_ajax', 'update_cart_ajax');
add_action('wp_ajax_nopriv_update_cart_ajax', 'update_cart_ajax');

function blaar_get_cart_count() {
    if (WC()->cart) {
        echo WC()->cart->get_cart_contents_count();
    } else {
        echo 0;
    }
    wp_die();
}


add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    ob_start();
    ?>
    <span class="align-middle" id="cart-total">
        <?php echo WC()->cart->get_cart_contents_count(); ?>
    </span>
    <?php
    $fragments['#cart-count'] = ob_get_clean();
    return $fragments;
});


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

    $order_subtotal = WC()->cart->get_subtotal('raw');

    ob_start();
    wc_get_template('cart-checkout.php', [], '', get_stylesheet_directory() . '/woocommerce/');
    $cart_html = ob_get_clean();

    // Обновляем cart-collaterals и подытоги
    ob_start();
    wc_get_template('cart/cart-totals.php');
    $cart_collaterals_html = ob_get_clean();

    // Обновление таблицы ревью заказа
    ob_start();
    wc_get_template('checkout/review-order.php');  // Рендерим только таблицу ревью
    $checkout_review_html = ob_get_clean();


    wp_send_json_success([
        'cart_html'  => $cart_html,
        'cart_collaterals_html' => $cart_collaterals_html,
        'checkout_review_html'    => $checkout_review_html,
        'cart_count' => WC()->cart->get_cart_contents_count(),
        'order_total' => wc_price($order_subtotal),
    ]);
}



<?php

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
remove_all_actions('woocommerce_before_shop_loop');
remove_all_actions('woocommerce_shop_loop_header');
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
//remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );


add_action('wp_ajax_blaar_update_cart_quantity', 'blaar_update_cart_quantity');
add_action('wp_ajax_nopriv_blaar_update_cart_quantity', 'blaar_update_cart_quantity');

add_action('wp_ajax_blaar_get_cart_quantity', 'blaar_get_cart_quantity');
add_action('wp_ajax_blaar_get_cart_quantity', 'blaar_get_cart_quantity');

add_action('wp_ajax_blaar_filter_products_by_category', 'blaar_filter_products_by_category');
add_action('wp_ajax_nopriv_blaar_filter_products_by_category', 'blaar_filter_products_by_category');
function blaar_update_cart_quantity() {
    if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
        wp_send_json_error(['message' => 'Invalid request parameters']);
        wp_die();
    }

    $product_id = absint($_POST['product_id']);
    $quantity = absint($_POST['quantity']);

    if ($quantity < 0) {
        wp_send_json_error(['message' => 'Quantity cannot be negative']);
        wp_die();
    }

    $cart = WC()->cart;
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            $cart->set_quantity($cart_item_key, $quantity);
            WC()->cart->calculate_totals();

            wp_send_json_success(['message' => 'Cart updated']);
            wp_die();
        }
    }

    wp_send_json_error(['message' => 'Product not found in cart']);
    wp_die();
}
function blaar_get_cart_quantity() {
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

    if (!$product_id) {
        wp_send_json(['quantity' => 0]);
        wp_die();
    }

    $cart = WC()->cart->get_cart();
    $quantity = 0;

    foreach ($cart as $cart_item) {
        if ($cart_item['product_id'] == $product_id) {
            $quantity = $cart_item['quantity'];
            break;
        }
    }

    wp_send_json(['quantity' => $quantity]);
    wp_die();
}
function blaar_filter_products_by_category() {
    $category_id = isset($_POST['category_id']) ? (int) $_POST['category_id'] : 0;
    $page_id = isset($_POST['page_id']) ? (int) $_POST['page_id'] : 0;

    if (!$page_id) {
        echo '<p class="text-center text-gray-500 col-span-2 lg:col-span-3">Ошибка: не передан ID страницы</p>';
        wp_die();
    }

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
                'exclude'    => [15],
                'terms'    => $category_id,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ],
        ],
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            wc_get_template_part('content', 'product');
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p class="text-center text-gray-500 col-span-2 lg:col-span-3">Товары не найдены.</p>';
    endif;

    wp_die();
}




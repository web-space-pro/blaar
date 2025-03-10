<?php

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
remove_all_actions('woocommerce_before_shop_loop');
remove_all_actions('woocommerce_shop_loop_header');
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
//remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );

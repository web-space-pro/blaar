<?php

//remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

//remove_all_actions('woocommerce_before_shop_loop');
//remove_all_actions('woocommerce_shop_loop_header');
//remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
////remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );

// включить свотчи for related products
add_filter('cfvsw_requires_shop_settings', function ($status) {
    global $woocommerce_loop;

    if (is_product() && !empty($woocommerce_loop) && isset($woocommerce_loop['name']) && $woocommerce_loop['name'] == 'related') {
        return true;
    }
    return $status;
});
//изменить размер изображения в списке товаров
function blaar_loop_product_thumbnail_size($size) {
    return 'large'; // Или другой размер, например, 'large' или 'full'
}
add_filter('single_product_archive_thumbnail_size', 'blaar_loop_product_thumbnail_size');



// Получаем галерею вариации из Additional Variation Images Gallery
// для отображения доп-фото в loop products
// используется плагин для создания доп-галереии для вариативного продукта (variation gallery images)
add_filter('woocommerce_available_variation', function ($variation_data, $product, $variation) {

    $gallery_images = get_post_meta($variation->get_id(), 'vargal_params', true);
    $image_urls = [];

    if (!empty($gallery_images)) {
        if (!is_array($gallery_images)) {
            $gallery_images = maybe_unserialize($gallery_images);
        }

        if (is_array($gallery_images)) {
            foreach ($gallery_images as $image_id) {
                $image_src = wp_get_attachment_image_src($image_id, 'woocommerce_thumbnail');
                if (!empty($image_src[0])) {
                    $image_urls[] = $image_src[0];
                }
            }
        }
    }

    $variation_data['vargal_params'] = $image_urls;
    return $variation_data;
}, 10, 3);

// Если товара нет, не выводим кнопку
add_filter('woocommerce_loop_add_to_cart_link', function ($button, $product) {
    if (!$product->is_in_stock()) {
        return '';
    }
    return $button;
}, 10, 2);


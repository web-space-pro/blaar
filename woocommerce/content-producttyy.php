<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if the product is a valid WooCommerce product and ensure its visibility before proceeding.
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>

<?php
// вывод кастомного изображения
// Проверяем, является ли товар вариативным
if ($product->is_type('variable')) {
    $default_attributes = $product->get_default_attributes();
    $variations = $product->get_children();
    $default_variation_image = '';

//        echo '<pre>';
        //print_r( $meta_data );
//        echo '</pre>';



    if($default_attributes){
        foreach ($variations as $variation_id) {
            $variation = new WC_Product_Variation($variation_id);
            $match = true;

            foreach ($default_attributes as $key => $value) {
                if ($variation->get_attribute($key) !== $value) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                // Берем галерею из вариации
                $gallery_images = get_post_meta($variation_id, 'vargal_params', true);
                if (!empty($gallery_images) && is_array($gallery_images)) {
                    $default_variation_image = wp_get_attachment_image_url($gallery_images[0], 'woocommerce_thumbnail');
                }
                break;
            }
        }
    }
} else {
    // Для простого товара
    $gallery_images = $product->get_gallery_image_ids();

    if (!empty($gallery_images) && is_array($gallery_images)) {
        $default_variation_image = wp_get_attachment_image_url($gallery_images[0], 'woocommerce_thumbnail');
    } else {
        // Если галерея пустая, используем главное изображение товара
        $default_variation_image = wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail');
    }
}

//if (empty($default_variation_image)) {
//    $default_variation_image = wp_get_attachment_image_url($product->get_image_id(), 'woocommerce_thumbnail');
//}
?>

<li <?php wc_product_class( 'leading-4 flex flex-col items-stretch relative product', $product ); ?>>
    <div class="product-image relative w-full overflow-hidden mb-2 sm:mb-3 rounded-[2px]">
        <?php woocommerce_template_loop_product_link_open(); ?>
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
         do_action( 'woocommerce_before_shop_loop_item_title' );
        ?>
<!--        <div class="hover-img" data-product-id="--><?php //echo $product->get_id(); ?><!--">-->
<!--            --><?php //if (!empty($default_variation_image)) :?>
<!--                <img src="--><?php //echo esc_url($default_variation_image); ?><!--" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="--><?php //=get_bloginfo()?><!--">-->
<!--            --><?php //endif; ?>
<!--        </div>-->
        <?php woocommerce_template_loop_product_link_close(); ?>
    </div>

<!--    class="loop_content flex flex-col-reverse lg:flex-row gap-x-2 sm:gap-x-4 sm:gap-y-2 items-stretch justify-between-->
    <div class="loop_content flex flex-row gap-1">
        <?php
        woocommerce_template_loop_product_link_open();
        /**
         * Hook: woocommerce_shop_loop_item_title.
         *
         * @hooked woocommerce_template_loop_product_title - 10
         */
        do_action( 'woocommerce_shop_loop_item_title' );
        woocommerce_template_loop_product_link_close();
        ?>


        <div class="flex w-1/2 md:w-[60%] justify-between flex-col flex-wrap items-end gap-2 relative">
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_product_description - 4
             * @hooked woocommerce_template_loop_rating - 5 --removed
             * @hooked woocommerce_template_loop_rating - 6
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        </div>
        <div class="loop_add_to_cart">
            <?php
            /**
             * Hook: woocommerce_after_shop_loop_item.
             *
             * @hooked woocommerce_template_loop_product_link_close - 5
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action( 'woocommerce_after_shop_loop_item' );
            ?>
        </div>
    </div>
</li>


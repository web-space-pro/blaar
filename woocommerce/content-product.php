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
<li <?php wc_product_class( 'leading-4 flex flex-col items-stretch relative product', $product ); ?>>
    <div class="product-image relative w-full overflow-hidden mb-3 rounded-[2px]">
        <?php woocommerce_template_loop_product_link_open(); ?>
        <?php
        /**
         * Hook: woocommerce_before_shop_loop_item_title.
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
      //  do_action( 'woocommerce_before_shop_loop_item_title' );
        ?>
        <?php woocommerce_template_loop_product_link_close(); ?>
       <?php
       // Проверяем, является ли товар вариативным
       if ($product->is_type('variable')) {
           $default_attributes = $product->get_default_attributes();
           $variations = $product->get_children();
           $default_variation_image = '';

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
                   $gallery_images = get_post_meta($variation_id, 'woo_variation_gallery_images', true);
                   if (!empty($gallery_images) && is_array($gallery_images)) {
                       $default_variation_image = wp_get_attachment_image_src($gallery_images[0], 'woocommerce_thumbnail')[0];
                   }
                   break;
               }
           }
       }

       // Если у вариации нет галереи, берем галерею основного товара
       if (empty($default_variation_image)) {
           $gallery_images = $product->get_gallery_image_ids();
           $default_variation_image = !empty($gallery_images) ? wp_get_attachment_image_src($gallery_images[0], 'woocommerce_thumbnail')[0] : '';
       }
       ?>

        <div class="product-image relative w-full overflow-hidden mb-3 rounded-[2px]" data-product-id="<?php echo $product->get_id(); ?>">
            <a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
                <?php echo woocommerce_get_product_thumbnail(); ?>

                <?php if (!empty($default_variation_image)) : ?>
                    <span class="cfvsw-original-thumbnail">
                <img src="<?php echo esc_url($default_variation_image); ?>" class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt="">
            </span>
                <?php endif; ?>
            </a>
        </div>

    </div>
    <div class="loop_content flex flex-col grow md:flex-row gap-x-4 gap-y-2 items-stretch justify-between pr-2">
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


        <div class="flex justify-between md:flex-col items-end gap-2">
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
<!--        --><?php
//        if ($product->is_type('variable')) {
//            woocommerce_variable_add_to_cart();
//        }
//        ?>

    </div>
</li>


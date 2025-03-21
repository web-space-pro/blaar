<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
        <div class="flex gap-3 md:gap-4 flex-col xs:flex-row mb-8">
            <div class="w-full xs:w-1/2 sm:w-5/12 md:w-3/12 xl:w-4/12">
                <?php if (wp_is_mobile()) : ?>

                    <div id="woocommerce-default-gallery" class="xs:sticky top-14 xs:top-16">
                        <?php do_action('woocommerce_before_single_product_summary'); ?>
                    </div>
                <?php else : ?>

                    <div id="custom-product-gallery" class="custom-product-gallery">
                        <?php
                        $default_image = has_post_thumbnail() ? get_the_post_thumbnail_url($product->get_id(), 'full') : wc_placeholder_img_src();
                        $gallery_ids = $product->get_gallery_image_ids();
                        $default_gallery = [];

                        foreach ($gallery_ids as $id) {
                            $default_gallery[] = wp_get_attachment_url($id);
                        }

                        echo '<div id="product-gallery">';
                        echo '<img id="main-product-image" src="' . esc_url($default_image) . '" class="product-image" />';

                        echo '<div id="product-gallery-thumbs">';
                        foreach ($default_gallery as $img) {
                            echo '<img src="' . esc_url($img) . '" class="gallery-thumb" />';
                        }
                        echo '</div>';
                        echo '</div>';

                        if ($product->is_type('variable')) {
                            echo '<script>
                            let  variationImages = {};
                        ';

                            foreach ($product->get_available_variations() as $variation) {
                                $variation_id = $variation['variation_id'];
                                $variation_image = get_post_thumbnail_id($variation_id) ? wp_get_attachment_url(get_post_thumbnail_id($variation_id)) : $default_image;
                                $gallery_images = get_post_meta($variation_id, 'woo_variation_gallery_images', true);
                                $gallery_images = is_array($gallery_images) ? array_map('wp_get_attachment_url', $gallery_images) : [];

                                echo 'variationImages[' . $variation_id . '] = {
                image: "' . esc_url($variation_image) . '",
                gallery: ' . json_encode($gallery_images) . '
            };';
                            }

                            echo '</script>';
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="w-full xs:w-1/2 sm:w-7/12 md:w-9/12 xl:w-8/12 px-4 sm:px-auto ">
                <div class="summary entry-summary sm:sticky sm:top-20 flex justify-between">

                   <div class="hidden">
                       <?php
                       /**
                        * Hook: woocommerce_single_product_summary.
                        * удалено
                        * @hooked woocommerce_template_single_title - 5
                        * @hooked woocommerce_template_single_rating - 10
                        * @hooked woocommerce_template_single_price - 10
                        * @hooked woocommerce_template_single_excerpt - 20
                        * @hooked woocommerce_template_single_add_to_cart - 30
                        * @hooked woocommerce_template_single_meta - 40
                        * @hooked woocommerce_template_single_sharing - 50
                        * @hooked WC_Structured_Data::generate_product_data() - 60
                        */
                       do_action( 'woocommerce_single_product_summary' );
                       ?>
                   </div>
                    <div class="md:w-[63%]">
                        <?php
                        if (function_exists('woocommerce_breadcrumb')) {
                            woocommerce_breadcrumb();
                        }
                        ?>

                        <?php
                        /**
                         * title + wishlist
                         */
                        ?>
                        <div class="flex text-2xl xs:text-3xl font-bold font-oswald uppercase mb-4">
                            <?php
                            if (function_exists('woocommerce_template_single_title')) {
                                woocommerce_template_single_title();
                            }
                            ?>
                            <?php echo do_shortcode('[ti_wishlists_addtowishlist]'); ?>
                        </div>

                        <div>
                            <?php
                            global $product;

                            if ($product->is_type('variable')) {
                                // Если товар вариативный, показать цену только если вариация не выбрана
                                ?>
                                <div id="variation-price">
                                    <?php woocommerce_template_single_price(); ?>
                                </div>
                                <script>
                                    jQuery(function($) {
                                        let form = $('.variations_form');
                                        let priceContainer = $('#variation-price');

                                        form.on('show_variation', function(event, variation) {
                                            priceContainer.hide(); // Скрываем цену, если выбрана вариация
                                        });

                                        form.on('hide_variation', function() {
                                            priceContainer.show(); // Показываем цену, если вариация не выбрана
                                        });
                                    });
                                </script>
                                <?php
                            } else {
                                // Если товар простой, сразу выводим цену
                                woocommerce_template_single_price();
                            }
                            ?>

                            <?php if (function_exists('woocommerce_template_single_add_to_cart')): ?>
                               <div class="product-single_add_to_cart"><?= woocommerce_template_single_add_to_cart();?></div>
                            <?php endif; ?>

                            <?php blaar_display_product_attributes(); ?>
                        </div>
                        <div class="text-sm mt-6 xs:mt-4 *:mb-2">
                            <?php
                            if (function_exists('the_content')) {
                                the_content();
                            }
                            ?>
                        </div>



                    </div>
                    <div class="w-1/3 hidden">
                        <div class="bg-white-20 text-white-30 pt-24 px-6 pb-6">
                            <?php
                            if (function_exists('woocommerce_template_single_meta')) {
                                woocommerce_template_single_meta();
                            }
                            ?>

                            <?php
                            if (function_exists('woocommerce_template_single_sharing')) {
                                woocommerce_template_single_sharing();
                            }
                            ?>

                            <?php
                            if (function_exists('woocommerce_template_single_excerpt')) {
                                woocommerce_template_single_excerpt();
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="w-full px-4 sm:px-0 pt-2">
            <?php
            /**
             * Hook: woocommerce_after_single_product_summary.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_upsell_display - 15
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_after_single_product_summary' );
            ?>
        </div>

    </div>

<?php do_action( 'woocommerce_after_single_product' ); ?>

<?php
/**
 * Variable product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/variable.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attribute_keys  = array_keys( $attributes );
$variations_json = wp_json_encode( $available_variations );
$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
	<?php do_action( 'woocommerce_before_variations_form' ); ?>

	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
		<p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
	<?php else : ?>
		<table class="variations" cellspacing="0" role="presentation">
			<tbody>
				<?php foreach ( $attributes as $attribute_name => $options ) : ?>
					<tr>
						<th class="label"><label for="<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>"><?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label></th>
						<td class="value">
							<?php
								wc_dropdown_variation_attribute_options(
									array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
									)
								);
								/**
								 * Filters the reset variation button.
								 *
								 * @since 2.5.0
								 *
								 * @param string  $button The reset variation button HTML.
								 */
								echo end( $attribute_keys ) === $attribute_name ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#" aria-label="' . esc_attr__( 'Clear options', 'woocommerce' ) . '">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
							?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="reset_variations_alert screen-reader-text" role="alert" aria-live="polite" aria-relevant="all"></div>
		<?php do_action( 'woocommerce_after_variations_table' ); ?>

		<div class="product-board md:absolute md:top-6 md:right-0 md:w-1/3 mt-6 md:mt-0 bg-white-20 text-black-10 py-6 px-6 text-base">
            <?php
            // Проверяем, что это вариативный товар
            if ( $product->is_type('variable') ) {
                $variations = $product->get_available_variations();
                $regular_prices = [];
                $sale_prices = [];

                foreach ( $variations as $variation_data ) {
                    $variation = wc_get_product( $variation_data['variation_id'] );
                    $reg_price = (float) $variation->get_regular_price();
                    $sale_p    = (float) $variation->get_sale_price();

                    if ( $reg_price > 0 ) {
                        $regular_prices[] = $reg_price;
                        $sale_prices[]    = $sale_p;
                    }
                }

                // Если у всех вариаций одинаковая цена
                if ( !empty($regular_prices) && count(array_unique($regular_prices)) === 1 && count(array_unique($sale_prices)) === 1 ) {
                    $regular_price = $regular_prices[0];
                    $sale_price    = $sale_prices[0];

                    echo '<div class="variation-price">';

                    if ( $sale_price && $sale_price < $regular_price ) {
                        $discount_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                        echo '<p class="price">';
                        echo '<del>' . wc_price($regular_price) . '</del> <ins>' . wc_price($sale_price) . '</ins>';
                        echo ' <span class="price-discount">-' . $discount_percent . '%</span>';
                        echo '</p>';
                    } else {
                        echo '<p class="price"><ins>' . wc_price($regular_price) . '</ins></p>';
                    }

                    echo '</div>';
                }
            }
            ?>
            <?php
				/**
				 * Hook: woocommerce_before_single_variation.
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
				 *
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * Hook: woocommerce_after_single_variation.
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>

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
	<?php endif; ?>

	<?php do_action( 'woocommerce_after_variations_form' ); ?>
</form>

<?php
do_action( 'woocommerce_after_add_to_cart_form' );

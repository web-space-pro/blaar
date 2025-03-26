<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        /**
         * Filter the product name.
         *
         * @since 2.1.0
         * @param string $product_name Name of the product in the cart.
         * @param array $cart_item The product in the cart.
         * @param string $cart_item_key Key for the product in the cart.
         */
        $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ):
        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
        ?>
        <div class="flex flex-row gap-4 border-b border-gray-10 py-4 woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
            <div class="w-1/3 sm:w-2/12 product-image">
                <?php
                $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                if ( ! $product_permalink ) {
                    echo $thumbnail; // PHPCS: XSS ok.
                } else {
                    printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                }
                ?>
            </div>

            <div class="w-1/3 sm:w-5/12 flex flex-col justify-between">
                <div class="product-name uppercase text-base sm:text-xl leading-tight font-oswald font-normal text-black-10" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                    <?php
                    if ( ! $product_permalink ) {
                        echo wp_kses_post( $product_name . '&nbsp;' );
                    } else {
                        /**
                         * This filter is documented above.
                         *
                         * @since 2.1.0
                         */
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                    }

                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );


                    // Meta data.

                    echo wc_get_formatted_cart_item_data( $cart_item );

                    // Backorder notification.
                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                    }
                    ?>
                </div>
                <div class="flex items-center">
                    <div class="product-quantity leading-none" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
                        <div class="quantity-wrapper ">
                            <?php
                            if ( $_product->is_sold_individually() ):
                                $min_quantity = 1;
                                $max_quantity = 1;
                                echo 'В наличии - 1 шт';
                            else:

                                $min_quantity = 0;
                                $max_quantity = $_product->get_max_purchase_quantity();
                            endif;
                            $product_quantity = woocommerce_quantity_input(
                                array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $max_quantity,
                                    'min_value'    => $min_quantity,
                                    'product_name' => $product_name,
                                    'classes'      => ['input-text', 'qty', 'text'],
                                ),
                                $_product,
                                false
                            );
                                ?>

                                    <span class="<?php echo $_product->is_sold_individually() ? 'hidden' : ''; ?> qty-btn qty-minus cursor-pointer"><svg width="12" height="2" viewBox="0 0 12 2" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M0.833252 1C0.833252 0.723858 1.05711 0.5 1.33325 0.5H10.6666C10.9427 0.5 11.1666 0.723858 11.1666 1C11.1666 1.27614 10.9427 1.5 10.6666 1.5H1.33325C1.05711 1.5 0.833252 1.27614 0.833252 1Z" fill="#F5F5F5" /></svg></span>
                                    <?php echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); ?>
                                    <span class="<?php echo $_product->is_sold_individually() ? 'hidden' : ''; ?> qty-btn qty-plus cursor-pointer"><svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M6.00008 0.666656C6.26786 0.666656 6.48493 0.883731 6.48493 1.1515V5.51514H10.8486C11.1163 5.51514 11.3334 5.73221 11.3334 5.99999C11.3334 6.26776 11.1163 6.48484 10.8486 6.48484H6.48493V10.8485C6.48493 11.1162 6.26786 11.3333 6.00008 11.3333C5.73231 11.3333 5.51523 11.1162 5.51523 10.8485V6.48484H1.1516C0.883822 6.48484 0.666748 6.26776 0.666748 5.99999C0.666748 5.73221 0.883822 5.51514 1.1516 5.51514H5.51523V1.1515C5.51523 0.883731 5.73231 0.666656 6.00008 0.666656Z" fill="#F5F5F5" /></svg></span>
                                <?php
                            ?>
                        </div>
                    </div>

                    <div class="product-price ml-4 uppercase text-xs sm:text-base font-oswald font-bold text-gray-70" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>"
                       <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.?>
                    </div>
                </div>
            </div>

            <div class="w-1/3 sm:w-5/12 flex flex-col justify-between items-end">
                <div class="text-right">
                    <div class="product-subtotal uppercase text-base sm:text-xl font-oswald font-bold text-black-10" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.?>
                    </div>
                </div>
                <div class="product-remove uppercase text-xs font-oswald font-normal text-black-20">
                    <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" data-product_id="<?=$product_id?>" class="inline-block">
                        Удалить
                    </a>
               </div>
            </div>
        </div>
    <?php
       endif;
    endforeach;
         ?>

        <?php do_action( 'woocommerce_cart_contents' ); ?>

        <div class="mt-10 cart-footer hidden">
            <div class="actions">
                <div class="flex">
                    <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="coupon">
                            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                            <?php //do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="hidden">
                    <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                </div>
                <?php do_action( 'woocommerce_cart_actions' ); ?>

                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </div>
        </div>

         <?php do_action( 'woocommerce_after_cart_contents' ); ?>
    </div>

         <?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     *
     * @hooked woocommerce_cross_sell_display
     * @hooked woocommerce_cart_totals - 10
     */
    do_action( 'woocommerce_cart_collaterals' );
    ?>
</div>
<div class="mt-6 flex flex-col items-end gap-1">
    <label class="text-xs text-gray-30"><?php esc_html_e( 'Total', 'woocommerce' ); ?></label>
    <div class="uppercase text-xl font-oswald font-bold text-black-10 order-total">
        <span id="order-total-cart" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></span>
    </div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>

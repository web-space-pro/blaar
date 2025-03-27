<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order grid grid-cols-1 sm:grid-cols-2 gap-4">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
            <div class="col-span-1 sm:col-span-2">
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
                    <?php endif; ?>
                </p>
            </div>

		<?php else : ?>
            <div class=" text-base sm:text-xl text-center mt-3 mb-3 sm:mb-10 col-span-1 sm:col-span-2">
                <?php wc_get_template( 'checkout/order-received.php', array( 'order' => $order ) ); ?>

            </div>


        <div class="order-details mt-2">
            <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details border border-gray-10 shadow-sm rounded-lg p-4 md:p-6 space-y-3">
                <li class="woocommerce-order-overview__order order flex justify-between border-b pb-1 text-sm md:text-base">
                    <span><?php esc_html_e('Order number:', 'woocommerce'); ?></span>
                    <strong class="text-black-30"><?php echo $order->get_order_number(); ?></strong>
                </li>

                <li class="woocommerce-order-overview__date date flex justify-between border-b pb-1 mb-2 text-sm md:text-base">
                    <span><?php esc_html_e('Date:', 'woocommerce'); ?></span>
                    <strong class="text-black-30"><?php echo wc_format_datetime($order->get_date_created()); ?></strong>
                </li>

                <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                    <li class="woocommerce-order-overview__email email flex justify-between border-b pb-1 mb-2 text-sm md:text-base">
                        <span><?php esc_html_e('Email:', 'woocommerce'); ?></span>
                        <strong class="text-black-30"><?php echo $order->get_billing_email(); ?></strong>
                    </li>
                <?php endif; ?>

                <li class="woocommerce-order-overview__total total flex justify-between border-b pb-1 mb-2 text-sm md:text-base">
                    <span><?php esc_html_e('Total:', 'woocommerce'); ?></span>
                    <strong class="text-black-30"><?php echo $order->get_formatted_order_total(); ?></strong>
                </li>

                <?php if ($order->get_payment_method_title()) : ?>
                    <li class="woocommerce-order-overview__payment-method method flex justify-between text-sm md:text-base">
                        <span><?php esc_html_e('Payment method:', 'woocommerce'); ?></span>
                        <strong class="text-black-30"><?php echo wp_kses_post($order->get_payment_method_title()); ?></strong>
                    </li>
                <?php endif; ?>
            </ul>
        </div>


    <?php endif; ?>

		<?php //do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>

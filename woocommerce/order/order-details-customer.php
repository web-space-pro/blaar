<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<div class="woocommerce-customer-details">

	<?php if ( $show_shipping ) : ?>

     <div class="woocommerce-customer-details border border-gray-200 shadow-sm rounded-lg p-4 md:p-6">
        <?php if ($show_shipping) : ?>
            <div class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
                    <h2 class="woocommerce-column__title text-lg md:text-xl font-semibold mb-4">Данные доставки</h2>
                    <address class="text-sm leading-relaxed">
<!--                        --><?php //echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'woocommerce'))); ?>
                        <?php if ( $order->get_billing_first_name() ) : ?>
                            <p><strong>ФИО:</strong> <?php echo esc_html( $order->get_billing_first_name() ); ?></p>
                        <?php endif; ?>

                        <?php if ( $order->get_billing_city() ) : ?>
                            <p><strong>Город:</strong> <?php echo esc_html( $order->get_billing_city() ); ?></p>
                        <?php endif; ?>

                        <?php if ( $order->get_billing_address_1() ) : ?>
                            <p><strong>Улица:</strong> <?php echo esc_html( $order->get_billing_address_1() ); ?></p>
                        <?php endif; ?>

                        <?php if ( $order->get_billing_address_2() ) : ?>
                            <p><strong>Квартира:</strong> <?php echo esc_html( $order->get_billing_address_2() ); ?></p>
                        <?php endif; ?>

                        <?php
                        $shipping_method = $order->get_meta('_billing_shipping_method');
                        $shipping_methods_map = array(
                            'pickup'     => 'Самовывоз',
                            'courier'    => 'Доставка курьером',
                            'post'       => 'Почтовая доставка',
                            'express'    => 'Экспресс-доставка',
                        );

                        if ( isset( $shipping_methods_map[ $shipping_method ] ) ) : ?>
                            <p><strong>Способ доставки:</strong> <?php echo esc_html( $shipping_methods_map[ $shipping_method ] ); ?></p>
                        <?php endif; ?>


                        <?php if ( $order->get_meta('_billing_comments') ) : ?>
                            <p><strong>Комментарий к заказу:</strong> <?php echo esc_html( $order->get_meta('_billing_comments') ); ?></p>
                        <?php endif; ?>
                    </address>

                    <?php if ($order->get_billing_phone()) : ?>
                        <p class="woocommerce-customer-details--phone font-medium mt-2">
                            📞 <?php echo esc_html($order->get_billing_phone()); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($order->get_billing_email()) : ?>
                        <p class="woocommerce-customer-details--email font-medium mt-1">
                            ✉️ <?php echo esc_html($order->get_billing_email()); ?>
                        </p>
                    <?php endif; ?>

                    <?php
                    do_action('woocommerce_order_details_after_customer_address', 'billing', $order);
                    ?>
                </div>
            </div>
        <?php endif; ?>
    <?php do_action('woocommerce_order_details_after_customer_details', $order); ?>
     </div>
<?php endif; ?>
</div>

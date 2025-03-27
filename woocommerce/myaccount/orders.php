<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php if ( $has_orders ) : ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <?php foreach ($customer_orders->orders as $customer_order):
        $order      = wc_get_order($customer_order);
        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
    ?>
        <div class="woocommerce-order-card flex-1 border border-gray-200 rounded-lg p-4 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">
                    Заказ #<?php echo esc_html($order->get_order_number()); ?>
                </h2>

                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Дата заказа:</span>
                        <span class="font-medium"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Статус:</span>
                        <span class="font-medium"><?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Итоговая сумма:</span>
                        <span class="font-medium">
                    <?php echo wp_kses_post(sprintf(_n('%1$s за %2$s товар', '%1$s за %2$s товара', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count)); ?>
                </span>
                    </div>

                    <?php
                    $actions = wc_get_account_orders_actions($order);
                    if (!empty($actions)) : ?>
                        <div class="mt-5">
                            <?php foreach ($actions as $key => $action) :
                                $action_aria_label = empty($action['aria-label'])
                                    ? sprintf(__(' %1$s заказ №%2$s', 'woocommerce'), $action['name'], $order->get_order_number())
                                    : $action['aria-label'];
                                ?>
                                <a href="<?php echo esc_url($action['url']); ?>"
                                   class="woocommerce-button button btn <?php echo sanitize_html_class($key); ?>"
                                   aria-label="<?php echo esc_attr($action_aria_label); ?>">
                                    <?php echo esc_html($action['name']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    <?php endforeach; ?>
    </div>

    <?php do_action( 'woocommerce_before_account_orders_pagination' ); ?>

    <?php if ( 1 < $customer_orders->max_num_pages ) : ?>
        <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
            <?php if ( 1 !== $current_page ) : ?>
                <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr( $wp_button_class ); ?>" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page - 1 ) ); ?>"><?php esc_html_e( 'Previous', 'woocommerce' ); ?></a>
            <?php endif; ?>

            <?php if ( intval( $customer_orders->max_num_pages ) !== $current_page ) : ?>
                <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr( $wp_button_class ); ?>" href="<?php echo esc_url( wc_get_endpoint_url( 'orders', $current_page + 1 ) ); ?>"><?php esc_html_e( 'Next', 'woocommerce' ); ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php else : ?>

	<?php wc_print_notice( esc_html__( 'No order has been made yet.', 'woocommerce' ) . ' <a class="woocommerce-Button wc-forward button' . esc_attr( $wp_button_class ) . '" href="' . esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) . '">' . esc_html__( 'Browse products', 'woocommerce' ) . '</a>', 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>

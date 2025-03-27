<?php
/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.6.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

 // phpcs:disable WooCommerce.Commenting.CommentHooks.MissingHookComment

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$downloads          = $order->get_downloadable_items();
$actions            = array_filter(
	wc_get_account_orders_actions( $order ),
	function ( $action ) {
		return 'View' !== $action['name'];
	}
);

// We make sure the order belongs to the user. This will also be true if the user is a guest, and the order belongs to a guest (userID === 0).
$show_customer_details = $order->get_user_id() === get_current_user_id();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<?php if (!is_order_received_page()) {  ?>
    <div class="woocommerce-order-head border border-gray-10 shadow-sm rounded-lg p-4 md:p-6 mb-4">
        <h3 class="text-lg md:text-xl font-semibold mb-4">
            <?php printf(esc_html__('Заказ #%s', 'woocommerce'), $order->get_order_number()); ?>
        </h3>
        <ul class="text-sm mb-4 *:inline-block *:mr-6">
            <li><strong><?php esc_html_e('Дата заказа:', 'woocommerce'); ?></strong> <?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></li>
            <li><strong><?php esc_html_e('Статус:', 'woocommerce'); ?></strong> <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></li>
            <li><strong><?php esc_html_e('Общая сумма:', 'woocommerce'); ?></strong> <?php echo wp_kses_post($order->get_formatted_order_total()); ?></li>
        </ul>
    </div>
    <?php } ?>
    <div class="woocommerce-order-details row-span-2 border border-gray-10 shadow-sm rounded-lg p-4 md:p-6 mb-2 mt-2">
        <?php do_action('woocommerce_order_details_before_order_table', $order); ?>

        <h2 class="woocommerce-order-details__title text-lg md:text-xl font-semibold text-gray-800 mb-4">
            <?php esc_html_e('Order details', 'woocommerce'); ?>
        </h2>

        <table class="woocommerce-table woocommerce-table--order-details shop_table order_details w-full border border-gray-200 rounded-lg overflow-hidden"">
            <thead class="text-left text-sm border-b border-gray-10">
            <tr>
                <th class="woocommerce-table__product-name product-name p-3 text-left text-sm">
                    <?php esc_html_e('Product', 'woocommerce'); ?>
                </th>
                <th class="woocommerce-table__product-table product-total p-3 text-right text-sm">
                    <?php esc_html_e('Total', 'woocommerce'); ?>
                </th>
            </tr>
            </thead>

            <tbody>
            <?php
            do_action('woocommerce_order_details_before_order_table_items', $order);

            foreach ($order_items as $item_id => $item) {
                $product = $item->get_product();

                wc_get_template(
                    'order/order-details-item.php',
                    array(
                        'order'              => $order,
                        'item_id'            => $item_id,
                        'item'               => $item,
                        'show_purchase_note' => $show_purchase_note,
                        'purchase_note'      => $product ? $product->get_purchase_note() : '',
                        'product'            => $product,
                    )
                );
            }

            do_action('woocommerce_order_details_after_order_table_items', $order);
            ?>
            </tbody>

            <?php if (is_order_received_page()): ?>
                <tfoot>
                <tr>
                    <th class="p-1.5 text-left"></th>
                    <td class="p-1.5 text-right">
                        <?php
                        $wp_button_class = wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '';
                        foreach ($actions as $key => $action) {
                            $action_aria_label = empty($action['aria-label'])
                                ? sprintf(__(' %1$s order number %2$s', 'woocommerce'), $action['name'], $order->get_order_number())
                                : $action['aria-label'];
                            echo '<a href="' . esc_url($action['url']) . '" class="woocommerce-button button order-actions-button btn ' . sanitize_html_class($key) . esc_attr($wp_button_class) . '" aria-label="' . esc_attr($action_aria_label) . '">' . esc_html($action['name']) . '</a>';
                        }
                        ?>
                    </td>
                </tr>
                </tfoot>
            <?php endif; ?>

            <tfoot class="border-t border-gray-20">
            <?php foreach ($order->get_order_item_totals() as $key => $total) : ?>
                <tr>
                    <th class="p-1.5 text-left text-sm"><?php echo esc_html($total['label']); ?></th>
                    <td class="p-1.5 text-right text-sm font-medium"><?php echo wp_kses_post($total['value']); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if ($order->get_customer_note()) : ?>
                <tr>
                    <th class="p-1.5 text-left text-sm text-gray-40"><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                    <td class="p-1.5 text-right text-sm font-oswald text-gray-40"><?php echo wp_kses(nl2br(wptexturize($order->get_customer_note())), array('br' => array())); ?></td>
                </tr>
            <?php endif; ?>
            </tfoot>
        </table>

        <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
    </div>


<?php
/**
 * Action hook fired after the order details.
 *
 * @since 4.4.0
 * @param WC_Order $order Order data.
 */
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}

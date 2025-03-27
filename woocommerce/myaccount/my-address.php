<?php
/**
 * My Addresses
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'woocommerce' ),
			'shipping' => __( 'Shipping address', 'woocommerce' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'woocommerce' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>
   <?php // Получаем данные пользователя для отображения
    $user_id = get_current_user_id();
    $user = get_user_by('id', $user_id);

    // Получаем данные из профиля пользователя или из заказа
    $first_name = get_user_meta($customer_id, 'billing_first_name', true);

    $city = get_user_meta($customer_id, 'billing_city', true);
    $address = get_user_meta($customer_id, 'billing_address_1', true);
    $apartment = get_user_meta($customer_id, 'billing_apartment', true);
    $phone = get_user_meta($customer_id, 'billing_phone', true);
    $email = get_user_meta($customer_id, 'billing_email', true);
    ?>

    <p>Эти данные будут использованы по умолчанию при оформлении заказов</p>

    <div class="user-address-info mb-10 mt-4">
        <p><strong>ФИО:</strong> <?php echo esc_html($first_name); ?></p>
        <p><strong>Город:</strong> <?php echo esc_html($city); ?></p>
        <p><strong>Улица:</strong> <?php echo esc_html($address); ?></p>
        <p><strong>Квартира:</strong> <?php echo esc_html($apartment); ?></p>
        <p><strong>Телефон:</strong> <?php echo esc_html($phone); ?></p>
        <p><strong>Email:</strong> <?php echo esc_html($email); ?></p>
    </div>

    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', 'billing' ) ); ?>" class="edit btn">
        Изменить данные
    </a>

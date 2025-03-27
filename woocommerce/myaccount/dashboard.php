<?php
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<div class="mt-10">
    <div class="p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Добро пожаловать в личный кабинет!</h2>
        <p class="text-lg mb-6">Рады видеть вас в вашем личном кабинете! Используйте следующие возможности:</p>

        <ul class="space-y-4">
            <li class="flex items-center">
                <svg class="w-6 h-6 text-[#10283A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h-6m3-3v6M5 12a7 7 0 0114 0 7 7 0 01-14 0z"></path>
                </svg>
                <span class="text-gray-800">Просматривайте <a href="/my-account/orders">историю заказов</a> и отслеживайте их статус.</span>
            </li>
            <li class="flex items-center">
                <svg class="w-6 h-6 text-[#10283A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l2 2 4-4m1 4v8a2 2 0 002 2h4a2 2 0 002-2v-8a2 2 0 00-2-2h-4a2 2 0 00-2 2z"></path>
                </svg>
                <span class="text-gray-800">Управляйте <a href="/my-account/wishlist">избранными товарами</a>.</span>
            </li>
            <li class="flex items-center">
                <svg class="w-6 h-6 text-[#10283A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <span class="text-gray-800">Обновляйте <a href="/my-account/edit-address">информацию о доставке</a>.</span>
            </li>
            <li class="flex items-center">
                <svg class="w-6 h-6 text-[#10283A] mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6m-3 3v6m-4 2a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="text-gray-800">Измените <a href="/my-account/edit-account/">личные данные</a>.</span>
            </li>
        </ul>
    </div>
</div>




<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );

	/**
	 * Deprecated woocommerce_before_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_before_my_account' );

	/**
	 * Deprecated woocommerce_after_my_account action.
	 *
	 * @deprecated 2.6.0
	 */
	do_action( 'woocommerce_after_my_account' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

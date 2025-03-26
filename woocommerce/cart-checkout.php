<?php
/**
 * Template Name: Cart & Checkout
 */
defined('ABSPATH') || exit;

get_header();
?>

<main class="relative px-4 xs:px-6 py-8 xs:py-10">
    <section class="custom-cart-checkout flex gap-10 flex-col md:flex-row">
        <div class="cart-section w-1/2">
            <h2><?php esc_html_e('Your Cart', 'woocommerce'); ?></h2>
            <?php echo do_shortcode('[woocommerce_cart]'); ?>
            <div class="mt-6 flex flex-col items-end gap-1">
                <label class="text-xs text-gray-30"><?php esc_html_e( 'Total', 'woocommerce' ); ?></label>
                <div class="uppercase text-xl font-oswald font-bold text-black-10 order-total">
                    <span id="order-total-cart" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></span>
                </div>
            </div>

        </div>
        <div class="checkout-section w-1/2">
            <h2><?php esc_html_e('Checkout', 'woocommerce'); ?></h2>
            <?php echo do_shortcode('[woocommerce_checkout]'); ?>
        </div>
    </section>
    <div>
        <?php
        // Выводим уведомления
        wc_print_notices();

        // Форма корзины и другие элементы
        ?>
    </div>
</main>
<?php get_footer(); ?>

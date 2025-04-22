<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blaar
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (!is_cart() && !is_checkout() && !is_wc_endpoint_url('order-received') && !is_account_page()): ?>
        <div class="w-full md:w-10/12 xl:w-8/12 m-auto">
            <h1 class="text-4xl xl:text-6xl text-center font-oswald font-normal uppercase tracking-wide text-black-10"><?php the_title(); ?></h1>
            <div class="mt-10 *:mb-4 sm:*:mb-8 text-gray-60 font-medium page-content">
                <?php the_content(); ?>
            </div>
        </div>
    <?php else:?>
        <div class="w-full">
            <?php if (is_cart()): ?>
                <div class="flex flex-row justify-between items-center">
                    <h1 class="text-4xl xl:text-6xl font-oswald font-normal uppercase tracking-wide text-black-10"><?php the_title(); ?></h1>
                </div>
                <div class="max-w-full mt-8 sm:mt-10">
                    <div class="flex gap-6 sm:gap-20 xl:gap-32 flex-col md:flex-row woocommerce-cart-checkout">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php elseif(is_account_page()): ?>
                <?php
                $current_user = wp_get_current_user();
                $logout_url = wp_logout_url( home_url() );
                ?>

                <div class="w-full xl:w-8/12 m-auto">
                    <div class="flex flex-row gap-4  items-center justify-between">
                        <div>

                            <h1 class="text-base sm:text-xl xl:text-2xl tracking-[-0.02em] font-oswald font-normal uppercase text-black-10">
                              <?=!$current_user ? 'Добро пожаловать,':'Добро пожаловать' ?>
                            </h1>
                            <?php if (is_user_logged_in()): ?>
                            <h2  class="text-xl sm:text-2xl xl:text-3xl tracking-[-0.02em] font-oswald font-normal uppercase  text-black-10">
                                <?=$current_user->user_firstname;?>
                            </h2>
                            <?php endif;?>
                        </div>
                        <?php if (is_user_logged_in()): ?>
                        <div>
                            <a class="btn secondary" href="<?=esc_url( $logout_url ) ?>">Выйти из аккаунта</a>
                        </div>
                        <?php endif;?>
                    </div>
                    <div class="max-w-full mt-8 sm:mt-10">
                        <?php the_content(); ?>
                    </div>
                </div>

            <?php else: ?>
                <h1 class="text-4xl xl:text-6xl font-oswald font-normal uppercase tracking-wide text-black-10"><?php the_title(); ?></h1>
                <div class="max-w-full mt-4">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</article>

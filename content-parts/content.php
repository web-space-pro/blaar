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
        <div class="flex flex-col md:flex-row gap-4 md:gap-16">
            <div class="w-full">
                <h1 class="hidden md:block text-2xl md:text-[1.75rem] leading-tight font-medium text-black"><?php the_title(); ?></h1>
                <div class="max-w-full mt-4 pt-5 border-t border-gray-10 font-sans *:mb-4">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    <?php else:?>
        <div class="flex flex-col md:flex-row gap-4 md:gap-16">
            <div class="w-full">
                <?php if (is_cart()): ?>
                    <div class="flex flex-row justify-between items-center">
                        <h1 class="text-2xl md:text-[1.75rem] lowercase leading-tight font-medium text-black"><?php the_title(); ?></h1>
                        <?php if (!WC()->cart->is_empty()) : ?>
                            <a href="#" target="_self">поделиться корзиной</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <h1 class="text-2xl md:text-[1.75rem] lowercase leading-tight font-medium text-black"><?php the_title(); ?></h1>
                <?php endif; ?>
                <div class="max-w-full mt-4 pt-5 border-t border-gray-10 font-sans *:mb-4">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</article>

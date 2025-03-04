<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blaar
 */

?>

<footer class="flex justify-between w-full  bottom-0 md:sticky z-40 items-center flex-row xs:flex-col lg:flex-row gap-4 bg-white backdrop-blur-md px-[2.8vmax] pt-[1vmax] pb-[2.2vmax] xs:pb-[1vmax]">
    <div class="flex lg:basis-4/5 justify-between items-start">
        <nav class="flex flex-row" role="navigation">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'menu-1',
                    'menu_id'        => 'primary-menu',
                )
            );
            ?>
        </nav>
    </div>
    <div class="xs:w-full">
        <div class="flex flex-col xs:flex-row justify-between items-end xs:items-center">
            <div class="xs:mb-0 mb-8 order-1">
                <a href="<?=get_home_url()?>" target="_self">
                    logo
                </a>
            </div>
            <p class="normal-case text-gray-20 font-sans text-right xs:order-2 order-3">© 2025. Кортрайт</p>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>

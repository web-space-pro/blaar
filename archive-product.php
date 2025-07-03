<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blaar
 */

get_header();
?>

    <main class="min-h-[50svh] xs:min-h-svh flex-grow-1 flex flex-col">

        <?php
        // Получаем ID страницы магазина WooCommerce
        $shop_page_id = wc_get_page_id('shop');

        $acf_has_blocks = function_exists('have_rows') && have_rows('components', $shop_page_id);

        if ($acf_has_blocks) :
            // Если в ACF есть хотя бы один блок — загружаем только ACF-контент
            while (have_rows('components', $shop_page_id)) :
                the_row();
                $layout = get_row_layout();
                $inclusion = get_stylesheet_directory() . "/block-parts/tpl-{$layout}.php";
                if (file_exists($inclusion)) {
                    include $inclusion;
                }
            endwhile;
        else :
            // Если ACF блоков нет, выводим стандартный архив товаров
            if (have_posts()) :
                woocommerce_product_loop_start();

                while (have_posts()) :
                    the_post();
                    wc_get_template_part('content', 'product');
                endwhile;

                woocommerce_product_loop_end();
            else :
                echo '<p>Товары не найдены</p>';
            endif;
        endif;
        ?>
    </main>
<?php
get_footer();
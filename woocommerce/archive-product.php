<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<main class="relative px-4 xs:px-6 py-8 xs:py-10">
    <section class="relative">
        <div class="sm:mt-2">
            <?php
            /**
             * Hook: woocommerce_before_main_content.
             *
             * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
             * @hooked woocommerce_breadcrumb - 20
             * @hooked WC_Structured_Data::generate_website_data() - 30
             */
            do_action( 'woocommerce_before_main_content' );
            ?>

            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                $current_category = get_queried_object();

                if ($current_category && isset($current_category->term_id)) {
                    // Проверяем, является ли текущая категория родительской
                    if ($current_category->parent == 0) {
                        $child_categories = get_terms([
                            'taxonomy'   => 'product_cat',
                            'parent'     => $current_category->term_id,
                            'hide_empty' => false
                        ]);

                        // Если у родительской категории есть подкатегории, не выводим хлебные крошки
                        if (!empty($child_categories)) {
                            $hide_breadcrumbs = true;
                        }
                    }

                    // Если хлебные крошки не скрыты, показываем их
                    if (empty($hide_breadcrumbs)) {
                        woocommerce_breadcrumb();
                    }
                }
            }
            ?>


        </div>

        <div class="mb-10 xl:mb-12">
            <?php
            /**
             * Hook: woocommerce_shop_loop_header.
             *
             * @since 8.6.0
             *
             * @hooked woocommerce_product_taxonomy_archive_header - 10
             */
            do_action( 'woocommerce_shop_loop_header' );

            ?>
        </div>


        <div class="mb-4 xs:mb-8 mt-8 xs:mt-12 flex gap-5 xs:gap-10 flex-col md:flex-row justify-between items-center relative flex-wrap">
            <?php
            // Получаем текущую категорию
            $current_term = get_queried_object();
            // Проверяем, что это объект типа WP_Term
            if (isset($current_term->term_id)) {
                // Это категория, работаем с её term_id
                if (is_shop()) {
                    // Если это главная страница магазина — показываем только главные категории
                    $parent = 0;
                } elseif (is_product_category()) {
                    // Проверяем, если у категории есть родитель, то берём его
                    if ($current_term->parent != 0) {
                        $parent = $current_term->parent;
                    } else {
                        $parent = $current_term->term_id;
                    }
                } else {
                    $parent = 0;
                }
            } else {
                // Если это не категория - то выход
                $parent = 0;
            }

            // Получаем дочерние категории текущей категории
            $child_terms = get_terms(array(
                'taxonomy'   => 'product_cat',
                'orderby'    => 'name',
                'order'      => 'ASC',
                'hide_empty' => false,
                'exclude'    => '15',
                'parent'     => isset($current_term->term_id) ? $current_term->term_id : 0, // Проверяем родительскую категорию
            ));

            if (empty($child_terms)) {
                // Если нет дочерних категорий, выводим все подкатегории родителя
                $terms = get_terms(array(
                    'taxonomy'   => 'product_cat',
                    'orderby'    => 'name',
                    'order'      => 'ASC',
                    'hide_empty' => false,
                    'parent'     => $parent, // Берем все подкатегории текущего родителя
                    'exclude'    => '15'
                ));
            } else {
                // Если дочерние категории есть, выводим их
                $terms = $child_terms;
            }

            if (!empty($terms)): $counter = 0; ?>
                <div class="product-categories overflow-hidden flex-1 w-full">
                    <div class="flex gap-2 sm:gap-4 font-oswald items-center overflow-x-auto scrollbar-none">
                        <?php foreach ($terms as $term) :
                            $is_active = (is_product_category() && isset($current_term->term_id) && $current_term->term_id == $term->term_id) ? 'border-gray-40' : 'border-white-40';

                            if($counter == 0): ?>
                                <a href="#"
                                   id="show-filters"
                                   class="open-modal w-fit link uppercase  px-6 py-3 shrink-0 outline-none border bg-black-20 text-white-30 hover:border-gray-40">
                                    Фильтры
                                </a>
                                <?php $counter++; endif;
                            ?>
                            <a href="<?= esc_url(get_term_link($term)) ?>"
                               data-id="<?= $term->term_id ?>"
                               data-name="<?= $term->slug ?>"
                               class="<?= $is_active ?> w-fit link uppercase  px-6 py-3 shrink-0 outline-none border hover:border-gray-40">
                                <?= esc_html($term->name) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php
            if ( woocommerce_product_loop() ) {
                echo '<div class="catalog_ordering text-right w-full lg:w-auto">';
                /**
                 * Hook: woocommerce_before_shop_loop.
                 *
                 * @hooked woocommerce_output_all_notices - 10
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                do_action( 'woocommerce_before_shop_loop' );
                echo '</div>';
            }
            ?>
            <div id="product-filters" class="product-filters hidden w-[75%] sm:max-w-96 lg:max-w-full lg:w-full h-screen lg:h-auto overflow-x-auto lg:overflow-hidden z-50 fixed top-0 lg:absolute left-0 lg:right-0 lg:top-12 z-10 bg-white-10 px-8  lg:px-4 py-8">
                <button id="close-filters">&times;</button>
                <?php echo do_shortcode('[wpf-filters id=1]') ?>
            </div>
        </div>

        <div>
            <?php
            if ( woocommerce_product_loop() ) {

                woocommerce_product_loop_start();

                if ( wc_get_loop_prop( 'total' ) ) {
                    while ( have_posts() ) {
                        the_post();

                        /**
                         * Hook: woocommerce_shop_loop.
                         */
                        do_action( 'woocommerce_shop_loop' );

                        wc_get_template_part( 'content', 'product' );
                    }
                }

                woocommerce_product_loop_end();

                /**
                 * Hook: woocommerce_after_shop_loop.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action( 'woocommerce_after_shop_loop' );
            } else {
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' );
            }

            ?>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );

        ?>
    </section>
</main>
<?php get_footer( 'shop' ); ?>

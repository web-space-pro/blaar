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
        <div class="mb-2">
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
        </div>

        <div class="mb-12">
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

        <?php
        /**
         * Выводим категории
         */
        ?>
        <div class="mb-8 mt-12">
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

            if (!empty($terms)): ?>
                <div class="product-categories">
                    <div class="flex gap-2 sm:gap-4 font-oswald items-center overflow-x-auto scrollbar-none">
                        <?php foreach ($terms as $term) :
                            $is_active = (is_product_category() && isset($current_term->term_id) && $current_term->term_id == $term->term_id) ? 'border-gray-40' : 'border-white-40';
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






        </div>

        <div>
            <?php
            if ( woocommerce_product_loop() ) {
                echo '<div>';
                /**
                 * Hook: woocommerce_before_shop_loop.
                 *
                 * @hooked woocommerce_output_all_notices - 10
                 * @hooked woocommerce_result_count - 20
                 * @hooked woocommerce_catalog_ordering - 30
                 */
                do_action( 'woocommerce_before_shop_loop' );
                echo '</div>';

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

        <div>
            <?php
            /**
             * Hook: woocommerce_after_main_content.
             *
             * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
             */
            do_action( 'woocommerce_after_main_content' );

            ?>
        </div>

        <div>
            <?php
            /**
             * Hook: woocommerce_sidebar.
             *
             * @hooked woocommerce_get_sidebar - 10
             */
//            do_action( 'woocommerce_sidebar' );
            ?>
        </div>

    </section>
</main>
<?php get_footer( 'shop' ); ?>

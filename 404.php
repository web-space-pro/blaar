<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package blaar
 */

get_header();
?>

    <section class="error-404 not-found min-h-[75svh] flex sm:items-center flex-col justify-center px-4 pt-6 sm:px-[2.8vmax]">
        <div class="sm:w-[80%] xl:w-[45%] sm:m-auto mb-10">
            <div class="text-[1.75rem] sm:text-4xl font-medium mb-8 sm:mb-4 leading-tight">
                <h1 class="text-gray-20"><?php esc_html_e( 'Ошибка 404.', 'blaar' ); ?></h1>
                <p class="w-80 sm:mt-4"><?php esc_html_e( 'такой страницы не существует', 'blaar' ); ?></p>
            </div>
            <div class="sm:w-[19rem] sm:ml-auto font-sans text-gray-10">
                <p><?php esc_html_e( 'но есть много другой интересной и полезной информации, которую вы обязательно найдете в разделах сайта', 'blaar' ); ?></p>
            </div>
            <div class="mt-16 sm:mt-4">
                <a href="<?=get_home_url()?>" target="_self" class="link sm:w-auto"> <?php esc_html_e( 'на главную', 'blaar' ); ?></a>
            </div>
        </div>
    </section>

<?php
get_footer();

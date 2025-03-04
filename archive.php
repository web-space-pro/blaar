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

    <main class="min-h-svh flex-grow-1 flex flex-col px-4 sm:px-[2.8vmax] pt-6 pb-6">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <?php
            /* Start the Loop */
            while ( have_posts() ) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part( 'content-parts/content', get_post_type() );

            endwhile;

            the_posts_navigation();

        else :

            get_template_part( 'content-parts/content', 'none' );

        endif;
        ?>
    </main>

<?php
get_sidebar();
get_footer();

<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package blaar
 */

get_header();
?>
    <main class="min-h-svh flex-grow-1 flex flex-col px-4 sm:px-[2.8vmax] pt-6 pb-6">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'content-parts/content', get_post_type() );
        endwhile;
        ?>
    </main>
<?php
//get_sidebar();
get_footer();

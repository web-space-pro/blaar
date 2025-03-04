<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package blaar
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('w-full md:w-2/3 lg:w-3/4 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 order-1 md:order-2'); ?>>

    <!-- Заголовок -->
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4"><?php the_title(); ?></h1>

    <!-- Инфо о посте -->
    <div class="text-gray-600 dark:text-gray-400 text-sm mb-6">
        Опубликовано <?php the_date(); ?> в <?php the_category(', '); ?>
    </div>

    <!-- Изображение -->
    <?php if (has_post_thumbnail()) : ?>
        <img class="w-full h-64 object-cover rounded-lg mb-6" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
    <?php endif; ?>

    <!-- Контент -->
    <div class="prose dark:prose-invert max-w-full">
        <?php the_content(); ?>
    </div>

    <!-- Навигация между постами -->
    <div class="flex justify-between mt-8 border-t pt-4">
        <?php previous_post_link('<span class="text-blue-600 dark:text-blue-400 hover:underline">&larr; %link</span>'); ?>
        <?php next_post_link('<span class="text-blue-600 dark:text-blue-400 hover:underline">%link &rarr;</span>'); ?>
    </div>

    <!-- Комментарии -->
    <div class="mt-8">
        <?php
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;
        ?>
    </div>

    <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer">
            <?php
            edit_post_link(
                sprintf(
                    wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Edit <span class="screen-reader-text">%s</span>', 'simbiotica' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                ),
                '<span class="edit-link">',
                '</span>'
            );
            ?>
        </footer><!-- .entry-footer -->
    <?php endif; ?>
</article>

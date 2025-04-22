<?php
if ( function_exists('get_field') ) {
    $show  = get_sub_field('show_page_content');
}
?>
<?php if($show):?>
    <section class="relative px-4 xs:px-6 py-8 xs:py-10">
        <div class="w-full md:w-10/12 xl:w-8/12 m-auto">
            <h1 class="text-4xl xl:text-6xl text-center font-oswald font-normal uppercase tracking-wide text-black-10"><?php the_title(); ?></h1>
            <div class="mt-10 *:mb-4 sm:*:mb-8 text-gray-60 font-medium page-content">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
<?php endif;?>


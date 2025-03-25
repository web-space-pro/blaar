<?php
if ( function_exists('get_field') ) {
    $product_list  = get_sub_field('product_list');
    $image  = get_sub_field('image');
    $title  = get_sub_field('title');
    $subtitle  = get_sub_field('subtittle');
    $link  = get_sub_field('link');
    $settings  = get_sub_field('setings');
}
?>
<section class="relative px-4 xs:px-6 py-8 xs:py-10">
    <div class="flex flex-col gap-4 <?=!($settings["align_image_block"]) ? 'sm:flex-row-reverse' : 'sm:flex-row';?>">
        <div class="w-full sm:w-1/2">
         <?php   if (!empty($product_list)) : ?>
            <ul id="products-list" class="products-list --custom h-full grid gap-y-4 gap-x-[1.2vmax] sm:gap-y-[1.2vmax] grid-cols-2">
                <?php foreach ($product_list as $post) :
                    setup_postdata($post); ?>
                    <?php wc_get_template_part('content', 'product'); ?>
                <?php endforeach;
                wp_reset_postdata(); ?>
            </ul>
            <?php endif; ?>
        </div>
        <div class="w-full sm:w-1/2">
            <div class="h-[65svh] sm:h-full relative bg-gradient">
                <?php if(!empty($image['url'])): ?>
                <div class="h-full <?=!($settings["gradient"]) ? 'bg-gradient-black bg-image-cover --black' : 'bg-image-cover'?>">
                    <img  width="100%" height="100%" class="full-image w-full h-full object-cover object-center" src="<?=$image['url']?>" alt="<?=get_bloginfo()?>">
                </div>
                <?php endif;?>

                <?php if(!empty($title) || !empty($subtitle) || !empty($link)): ?>
                    <div class="absolute z-10 bottom-0 w-full p-4 sm:p-7 flex gap-4 flex-col sm:flex-row justify-between sm:items-end">
                        <div class="w-9/12 sm:w-2/3 xl:w-1/2 text-sm font-medium leading-tight <?=!($settings["gradient"]) ? 'text-gray-30' : ''?> rellax"data-rellax-speed="1" data-rellax-percentage="0">
                            <?php if(!empty($title)): ?>
                            <h2 class="text-2xl xl:text-3xl uppercase mb-3 font-oswald <?=!($settings["gradient"]) ? 'text-white-20' : ''?>"><?=$title?></h2>
                            <?php endif;?>
                            <?php if(!empty($subtitle)): ?>
                                <p><?=$subtitle?></p>
                            <?php endif;?>

                        </div>
                        <?php if(!empty($link)): ?>
                            <div class="w-full sm:w-1/3 xl:w-1/2 sm:text-right rellax" data-rellax-speed="1" data-rellax-percentage="0">
                                <a
                                        href="<?=$link['url']?>"
                                        target="<?= !empty($link['target']) ? $link['target'] : '_self' ?>"
                                        class="btn <?=!($settings["gradient"]) ? '--white' : ''?>">
                                    <?=$link['title']?>
                                </a>
                            </div>
                        <?php endif;?>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

<?php
if ( function_exists('get_field') ) {
    $sliderItems  = get_sub_field('slider-items');
}
?>
<?php if(!empty($sliderItems)) : ?>
<section class="h-slider relative bg-black-40/20">
    <div class="slider stick-dots">
        <?php foreach($sliderItems as $key=>$item): ?>
            <div class="relative slide h-full">
                <div class="slide__img w-full h-[25rem] md:h-full overflow-hidden md:absolute md:top-1/2 left-0  md:-translate-y-1/2">
                    <img src="<?=$item['image']['url']?>"
                         alt="<?=get_bloginfo()?>"
                         width="100%"
                         height="100%"
                         data-lazy="<?=$item['image']['url']?>"
                         class="full-image w-full h-full object-cover object-center opacity-100  animated"
                         data-animation-in="zoomInImage"/>
                </div>
                <div class="slide__content relative z-10 md:absolute bottom-0 md:bottom-8 right-0 md:right-6 left-0 md:left-6 bg-white-30 md:bg-transparent p-4 md:p-0">
                    <div class="slide__content--headings relative z-10">
                        <div class="relative z-10 md:flex md:justify-between flex-col md:flex-row  md:items-center w-full">
                            <?php if (!empty($item['title'])) : ?>
                                <?php if ($key == 0) : ?>
                                    <h1 data-animation-in="fadeInUp" class="animated md:w-1/2 leading-tight text-4xl xl:text-6xl font-oswald font-normal uppercase tracking-wide text-black-10 md:text-white-30">
                                        <?= $item['title'] ?>
                                    </h1>
                                <?php else : ?>
                                    <h2 data-animation-in="fadeInUp" class="animated md:w-1/2 leading-tight text-4xl xl:text-6xl font-oswald font-normal uppercase tracking-wide text-black-10 md:text-white-30">
                                        <?= $item['title'] ?>
                                    </h2>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if(!empty($item['link'])) : ?>
                            <a href="<?=$item['link']['url']?>" target="<?= !empty($item['link']['target']) ? $item['link']['target'] : '_self' ?>" class="animated btn mt-8 md:mt-0 mb-8 md:mb-0" data-animation-in="fadeInUp"><?=$item['link']['title']?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
       <?php endforeach; ?>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 44 44" width="44px" height="44px" id="circle" fill="none" stroke="currentColor">
            <circle r="20" cy="22" cx="22" id="test">
        </symbol>
    </svg>
</section>
<?php endif; ?>

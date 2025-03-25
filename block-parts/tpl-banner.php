<?php
if ( function_exists('get_field') ) {
    $image  = get_sub_field('image');
    $title  = get_sub_field('title');
    $link  = get_sub_field('link');
    $variant  = get_sub_field('variants');
}
?>
<?php if($variant =="one"):?>
    <section class="relative md:h-svh flex items-center flex-col md:flex-row overflow-hidden rellax" data-rellax-speed="0" data-rellax-percentage="0">
    <?php if(!empty($image['url'])): ?>
    <div class="md:absolute w-full h-full">
        <img
                src="<?=$image['url']?>"
                alt="<?=get_bloginfo()?>"
                width="100%"
                height="100%"
                class="full-image w-full h-full object-cover object-center"
        />
    </div>
    <?php endif;?>
    <div class="relative z-10 w-full md:w-10/12 flex items-start md:items-center gap-4 justify-between m-auto px-4 xs:px-6 py-6 rellax" data-rellax-speed="-3" data-rellax-percentage="0.5">
        <?php if(!empty($title)): ?>
            <h2 class="text-2xl sm:text-3xl leading-tight uppercase mb-3 font-oswald sm:w-96">
                <?=$title?>
            </h2>
        <?php endif;?>
        <?php if(!empty($link)): ?>
            <a href="<?=$link['url']?>" target="<?= !empty($link['target']) ? $link['target'] : '_self' ?>" class="btn btn-long"><?=$link['title']?></a>
        <?php endif;?>
    </div>
</section>
<?php elseif($variant =="two"):?>
    <section class="relative md:h-svh flex items-center overflow-hidden flex-col md:flex-row  rellax" data-rellax-speed="0" data-rellax-percentage="0">
        <?php if(!empty($image['url'])): ?>
            <div class="md:absolute w-full h-full">
                <img
                        src="<?=$image['url']?>"
                        alt="<?=get_bloginfo()?>"
                        width="100%"
                        height="100%"
                        class="full-image w-full h-full object-cover object-center"
                />
            </div>
        <?php endif;?>
        <div class="relative z-10 w-full h-full text-center flex items-center flex-col justify-between gap-4 px-4 xs:px-6 py-6 md:py-20 rellax" data-rellax-speed="-1" data-rellax-percentage="0.5">
            <?php if(!empty($title)): ?>
                <h2 class="text-2xl sm:text-3xl leading-tight uppercase mb-3 font-oswald sm:w-96">
                    <?=$title?>
                </h2>
            <?php endif;?>

            <?php if(!empty($link)): ?>
                <a href="<?=$link['url']?>" target="<?= !empty($link['target']) ? $link['target'] : '_self' ?>" class="btn btn-long --white-black"><?=$link['title']?></a>
            <?php endif;?>
        </div>
    </section>
<?php else:?>
    <section class="relative md:h-svh flex items-center overflow-hidden flex-col md:flex-row  rellax" data-rellax-speed="0" data-rellax-percentage="0">
        <?php if(!empty($image['url'])): ?>
            <div class="md:absolute w-full h-full">
                <img
                        src="<?=$image['url']?>"
                        alt="<?=get_bloginfo()?>"
                        width="100%"
                        height="100%"
                        class="full-image w-full h-full object-cover object-center"
                />
            </div>
        <?php endif;?>
        <div class="md:hidden relative z-10 w-full md:w-10/12 flex items-start md:items-center gap-4 justify-between m-auto px-4 xs:px-6 py-6 rellax" data-rellax-speed="-1" data-rellax-percentage="0.5">
            <?php if(!empty($title)): ?>
                <h2 class="text-2xl sm:text-3xl leading-tight uppercase mb-3 font-oswald sm:w-96">
                    <?=$title?>
                </h2>
            <?php endif;?>
            <?php if(!empty($link)): ?>
                <a href="<?=$link['url']?>" target="<?= !empty($link['target']) ? $link['target'] : '_self' ?>" class="btn btn-long"><?=$link['title']?></a>
            <?php endif;?>
        </div>
    </section>
<?php endif;?>

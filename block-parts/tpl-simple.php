<?php
if ( function_exists('get_field') ) {
    $title  = get_sub_field('title');
    $titleTwo  = get_sub_field('title_two');
    $titleThree  = get_sub_field('title_three');

    $subtitle = get_sub_field('title_form');
    $contactForm = get_sub_field('contact_form');

    $contacts = get_sub_field('contacts');
    $phone = $contacts['phone'];
    $email = $contacts['email'];
    $messengers = $contacts['messengers'];
    $remark = $contacts['remarka'];
}
?>

<section class="mt-2 xl:mt-20 mb-4">
    <div class="sm:max-w-[43rem]">
        <?php if(!empty($title)) : ?>
            <h1 class="text-[1.75rem] sm:text-[2rem] lg:text-[2.5rem] font-medium leading-tight">
                <?=$title?>
                <span class="sm:block xs:pl-[7vmax]">
                    <?=$titleTwo?>
                    <span class="text-gray-20"><?=$titleThree?></span>
                </span>
            </h1>
        <?php endif; ?>
        <?php if(!empty($subtitle)) : ?>
            <div class="xs:ml-[7vmax] mt-4 sm:mt-8 sm:w-80 text-xl text-gray-10">
                <?=$subtitle?>
            </div>
        <?php endif; ?>
    </div>
    <div class="mt-10 sm:mt-16">
        <div class="flex flex-col sm:flex-row gap-10 justify-between xs:ml-[7vmax]">
            <?php if(!empty($contactForm)) : ?>
            <div class="w-full sm:w-4/6 lg:w-1/2 xl:w-2/6">
               <?= do_shortcode('[contact-form-7 id="'.$contactForm.'"]'); ?>
            </div>
            <?php endif; ?>
            <div class="w-full sm:w-2/6 md:w-1/3 lg:w-2/6 xl:w-2/6">
                <?php if(!empty($phone)) : ?>
                    <div class="font-sans mb-6">
                        <h3 class="font-reg text-gray-20 lowercase mb-1"><?=$phone['label']?></h3>
                        <a href="tel:<?=$phone['number']?>" target="_blank"><?=$phone['number']?></a>
                    </div>
                <?php endif; ?>

                <?php if(!empty($email)) : ?>
                    <div class="font-sans mb-6">
                        <h3 class="font-reg text-gray-20 lowercase mb-1"><?=$email['label']?></h3>
                        <a href="mailto:<?=$email['value']?>" target="_blank"><?=$email['value']?></a>
                    </div>
                <?php endif; ?>

                <?php if(!empty($messengers)) : ?>
                    <div class="font-sans">
                        <h3 class="font-reg text-gray-20 lowercase mb-1">написать в мессенджеры</h3>
                        <ul>
                            <?php foreach($messengers as $item): ?>
                                <li class="inline-block mr-6"><a href="<?=$item['link']['url']?>" target="<?=$item['link']['target']?>"><?=$item['link']['title']?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(!empty($remark)) : ?>
                    <div class="text-sm text-gray-20 mt-8 sm:mt-10 sm:mt-16  sm:pl-0 sm:max-w-72 font-sans">
                        <?=$remark?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

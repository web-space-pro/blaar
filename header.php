<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package blaar
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <?php wp_head(); ?>
</head>

<body <?php body_class('flex flex-col min-h-screen antialiased font-relaway font-normal leading-normal text-sm xs:text-base text-black-10 selection:bg-black-10 selection:text-white-10'); ?> data-page-id="<?php the_ID(); ?>">
<?php wp_body_open(); ?>

<header class="max-w-full-client-width px-4 top-0 sticky  z-40 w-full bg-white-20 backdrop-blur-md overflow-hidden">
    <div class="flex justify-between gap-4 items-center flex-wrap w-full py-4">
        <div class="hidden xl:flex xl:basis-5/12 justify-start">
            <nav class="hidden xs:flex flex-row" role="navigation">
                <?php header_nav(); ?>
            </nav>
        </div>
        <div class="xl:basis-36 flex justify-center">
            <a href="<?=get_home_url()?>" target="_self">
                <svg width="115" height="24" viewBox="0 0 115 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 21.3824C0.538836 21.3824 0.981821 21.3528 1.32377 21.291C1.66573 21.2317 1.92737 21.1156 2.10612 20.9427C2.303 20.7549 2.43771 20.5005 2.51025 20.1843C2.58278 19.8681 2.61905 19.4506 2.61905 18.9368V5.70553C2.61905 4.83103 2.45326 4.23814 2.11908 3.92935C1.78489 3.62055 1.08026 3.45751 0 3.44022V2.79792C0.432623 2.81522 0.935191 2.82757 1.51029 2.83745C2.0854 2.84733 2.67086 2.8498 3.2641 2.8498C3.85734 2.8498 4.4428 2.84486 5.01791 2.83745C5.59301 2.83004 6.10594 2.81522 6.5567 2.79792C7.29501 2.79792 8.03072 2.87204 8.76903 3.01779C9.50734 3.16354 10.1731 3.41551 10.7664 3.77619C11.3596 4.11957 11.8466 4.57905 12.2248 5.15217C12.6031 5.72777 12.7922 6.43429 12.7922 7.27668C12.7922 7.94615 12.6652 8.52421 12.4139 9.01334C12.1627 9.50247 11.8285 9.91749 11.4166 10.2609C11.0021 10.6215 10.5254 10.918 9.98659 11.1477C9.44776 11.3799 8.89856 11.5652 8.339 11.7011C9.16539 11.7184 9.96328 11.8468 10.7275 12.0865C11.4917 12.3261 12.1627 12.6695 12.7378 13.1166C13.331 13.5464 13.7999 14.0776 14.1418 14.7125C14.4838 15.3473 14.6548 16.0588 14.6548 16.8493C14.6548 18.3587 14.0253 19.5939 12.7663 20.5548C11.5072 21.5158 9.69904 21.9951 7.34164 21.9951C6.81834 21.9951 6.24324 21.9901 5.61374 21.9827C4.98423 21.9753 4.33659 21.9704 3.67082 21.9704C3.00505 21.9704 2.35223 21.9753 1.71495 21.9827C1.07508 21.9926 0.505158 21.9951 0 21.9951V21.3775L0 21.3824ZM4.42726 11.4985H6.04636C7.46857 11.4985 8.64987 11.1897 9.59542 10.5721C10.541 9.95455 11.0125 8.85771 11.0125 7.27668C11.0125 5.83646 10.5617 4.86067 9.66277 4.35425C8.76385 3.84783 7.59292 3.59585 6.15516 3.59585C5.97382 3.59585 5.69663 3.60573 5.31841 3.62055C4.94019 3.63785 4.64487 3.64526 4.42726 3.64526V11.4985ZM4.42726 18.9615C4.42726 19.4753 4.46353 19.8829 4.53606 20.1843C4.6086 20.4857 4.76144 20.7129 4.99459 20.8661C5.22774 21.0193 5.54897 21.1156 5.9531 21.1502C6.35722 21.1848 6.90124 21.2021 7.58515 21.2021C9.14984 21.2021 10.3959 20.8686 11.3233 20.1991C12.2507 19.5296 12.7144 18.5094 12.7144 17.1359C12.7144 15.4708 12.1575 14.2579 11.0409 13.4946C9.92442 12.7312 8.4763 12.3483 6.69659 12.3483H4.42985V18.9639L4.42726 18.9615Z" fill="#1D1D1B" />
                    <path d="M36.4854 22C35.5865 21.9827 34.5192 21.9654 33.2861 21.9481C32.053 21.9308 30.7888 21.9234 29.4935 21.9234C28.1982 21.9234 26.9029 21.9333 25.662 21.9481C24.4212 21.9654 23.3487 21.9827 22.4498 22V21.3824C22.9886 21.3824 23.4316 21.3429 23.7735 21.2663C24.1155 21.1897 24.3771 21.0464 24.5559 20.8414C24.7528 20.6364 24.8875 20.3473 24.96 19.9792C25.0325 19.6112 25.0688 19.127 25.0688 18.5242V5.96492C25.0688 5.4165 25.0274 4.97431 24.9471 4.63834C24.8667 4.30237 24.7269 4.0504 24.53 3.87994C24.3305 3.70949 24.0611 3.59585 23.7191 3.54644C23.3772 3.49457 22.9549 3.45998 22.4498 3.44269V2.77322C22.7736 2.80781 23.2606 2.83004 23.9082 2.83745C24.5559 2.84733 25.232 2.8498 25.9315 2.8498C26.6309 2.8498 27.3122 2.84486 27.9702 2.83745C28.6256 2.83004 29.1438 2.80781 29.522 2.77322V3.44269C28.9831 3.45998 28.5402 3.49457 28.1982 3.54644C27.8563 3.59832 27.5868 3.71937 27.3874 3.90711C27.1879 4.08004 27.0532 4.32708 26.9832 4.65316C26.9107 4.97925 26.8744 5.4165 26.8744 5.96492V18.5242C26.8744 19.1072 26.9366 19.5766 27.0635 19.9274C27.1905 20.2782 27.4314 20.5499 27.7915 20.7376C28.1516 20.9254 28.6697 21.0514 29.3432 21.1107C30.0168 21.17 30.895 21.1996 31.9752 21.1996C32.7679 21.1996 33.4337 21.1576 33.9726 21.0711C34.5114 20.9847 34.9699 20.8142 35.3481 20.5573C35.7082 20.3004 36.0139 19.9521 36.2652 19.5148C36.5165 19.0776 36.7522 18.5069 36.9672 17.8029H37.5605L36.4802 21.9975L36.4854 22Z" fill="#1D1D1B" />
                    <path d="M48.4123 18.628C48.0522 19.5716 47.9719 20.2633 48.1688 20.7006C48.3657 21.1378 49.0677 21.3577 50.2749 21.3577V22C49.376 21.9827 48.3864 21.9753 47.3061 21.9753C46.2259 21.9753 45.2544 21.9852 44.3918 22V21.2861C44.8788 21.2861 45.2726 21.2416 45.5782 21.1527C45.8839 21.0637 46.1456 20.9081 46.3606 20.6858C46.5756 20.4807 46.7647 20.2016 46.9279 19.8508C47.0885 19.5 47.2699 19.0578 47.4668 18.5267L53.5649 2H54.1038L60.0154 18.6008C60.1942 19.1319 60.3833 19.5716 60.5827 19.9125C60.7796 20.2559 60.9972 20.5227 61.2304 20.7105C61.4817 20.9155 61.7666 21.0662 62.0801 21.1601C62.3935 21.254 62.7692 21.3182 63.1992 21.3528V21.9951C62.7485 21.9951 62.2407 21.9901 61.6734 21.9827C61.106 21.9753 60.5258 21.9704 59.9325 21.9704C59.3393 21.9704 58.7305 21.9753 58.1658 21.9827C57.5984 21.9926 57.0984 21.9951 56.6684 21.9951V21.3528C57.2435 21.3528 57.6943 21.3182 58.0181 21.249C58.3419 21.1798 58.5569 21.044 58.6657 20.8365C58.7745 20.6314 58.7875 20.3473 58.7072 19.9867C58.6269 19.626 58.4948 19.1542 58.316 18.5711L56.9404 14.7619H49.8138L48.4097 18.623L48.4123 18.628ZM56.6451 13.8923L53.4613 4.80632L50.1687 13.8923H56.6477H56.6451Z" fill="#1D1D1B" />
                    <path d="M74.02 18.628C73.6599 19.5716 73.5796 20.2633 73.7765 20.7006C73.9733 21.1378 74.6754 21.3577 75.8826 21.3577V22C74.9837 21.9827 73.9941 21.9753 72.9138 21.9753C71.8335 21.9753 70.8621 21.9852 69.9994 22V21.2861C70.4864 21.2861 70.8802 21.2416 71.1859 21.1527C71.4916 21.0637 71.7532 20.9081 71.9682 20.6858C72.1833 20.4807 72.3724 20.2016 72.5356 19.8508C72.6988 19.5 72.8775 19.0578 73.0744 18.5267L79.1752 2H79.714L85.6256 18.6008C85.8044 19.1319 85.9935 19.5716 86.193 19.9125C86.3899 20.2559 86.6075 20.5227 86.8406 20.7105C87.0919 20.9155 87.3769 21.0662 87.6903 21.1601C88.0038 21.254 88.3794 21.3182 88.8094 21.3528V21.9951C88.3587 21.9951 87.8509 21.9901 87.2836 21.9827C86.7163 21.9753 86.136 21.9704 85.5428 21.9704C84.9495 21.9704 84.3407 21.9753 83.776 21.9827C83.2087 21.9926 82.7087 21.9951 82.2786 21.9951V21.3528C82.8538 21.3528 83.3045 21.3182 83.6283 21.249C83.9522 21.1798 84.1672 21.044 84.276 20.8365C84.3848 20.6314 84.3977 20.3473 84.3174 19.9867C84.2371 19.626 84.105 19.1542 83.9262 18.5711L82.5507 14.7619H75.424L74.02 18.623V18.628ZM82.2528 13.8923L79.069 4.80632L75.7764 13.8923H82.2553H82.2528Z" fill="#1D1D1B" />
                    <path d="M100.547 12.8869V18.5761C100.547 19.1418 100.578 19.6013 100.641 19.9521C100.703 20.3029 100.824 20.582 101.006 20.7895C101.203 20.9946 101.472 21.1403 101.814 21.2268C102.156 21.3132 102.615 21.3552 103.19 21.3552V21.9975C102.83 21.9802 102.327 21.9679 101.679 21.958C101.032 21.9506 100.356 21.9457 99.6561 21.9457C98.9567 21.9457 98.2753 21.9506 97.6173 21.958C96.9593 21.9679 96.462 21.9802 96.12 21.9975V21.3799C96.6407 21.3799 97.0681 21.3503 97.4023 21.2885C97.7365 21.2292 98.0007 21.1033 98.1976 20.9155C98.3945 20.7105 98.5344 20.4214 98.6173 20.0534C98.6976 19.6853 98.739 19.1912 98.739 18.5736V5.96492C98.739 5.43379 98.6976 5.00395 98.6173 4.67787C98.537 4.35178 98.3971 4.09486 98.1976 3.90464C97.9981 3.73419 97.7287 3.61808 97.3868 3.55632C97.0448 3.49704 96.6226 3.45751 96.1174 3.44022V2.77075C96.5682 2.78804 97.1329 2.8004 97.8168 2.81028C98.5007 2.82016 99.2105 2.82263 99.9488 2.82263C100.687 2.82263 101.407 2.81769 102.107 2.81028C102.809 2.80287 103.402 2.78804 103.889 2.77075C105.112 2.77075 106.125 2.93874 106.925 3.27223C107.726 3.60573 108.36 4.01334 108.829 4.49506C109.28 4.99407 109.599 5.52026 109.788 6.07856C109.977 6.63686 110.07 7.14575 110.07 7.61018C110.07 8.22777 109.956 8.79842 109.733 9.32213C109.508 9.84585 109.207 10.3127 108.829 10.7253C108.451 11.1551 108.018 11.5158 107.534 11.8073C107.047 12.0988 106.544 12.3137 106.024 12.4496C106.366 13.0153 106.767 13.6304 107.226 14.29C107.684 14.9496 108.156 15.5993 108.643 16.2342C109.13 16.8864 109.601 17.499 110.06 18.0746C110.518 18.6502 110.92 19.127 111.262 19.5025C111.694 20.0163 112.171 20.4536 112.692 20.8142C113.212 21.1749 113.816 21.3552 114.5 21.3552V21.9975C113.852 21.9629 113.207 21.9457 112.57 21.9457C111.933 21.9457 111.324 21.9629 110.749 21.9975C110.226 21.3626 109.679 20.6512 109.101 19.8607C108.526 19.0726 107.948 18.2747 107.373 17.4669C106.78 16.6443 106.208 15.8365 105.658 15.0484C105.109 14.2604 104.609 13.539 104.161 12.8869H100.545H100.547ZM100.547 11.9358C100.762 11.9876 101.096 12.0173 101.545 12.0247C101.995 12.0346 102.355 12.0371 102.625 12.0371C103.633 12.0371 104.482 11.9135 105.177 11.664C105.868 11.4145 106.43 11.086 106.863 10.6734C107.296 10.2782 107.607 9.82856 107.793 9.32213C107.982 8.81571 108.075 8.30435 108.075 7.79051C108.075 7.20751 107.982 6.65909 107.793 6.14279C107.604 5.62895 107.303 5.18182 106.889 4.80385C106.474 4.42589 105.936 4.12945 105.27 3.917C104.604 3.70208 103.785 3.59585 102.814 3.59585C102.4 3.59585 101.982 3.6082 101.56 3.63538C101.138 3.66008 100.799 3.69219 100.547 3.72431V11.9358Z" fill="#1D1D1B" />
                </svg>
            </a>
            <div class="xs:hidden">
                <div id="nav-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="xl:basis-5/12 flex justify-end">
            <div class="hidden xs:flex items-center gap-4">
                <a class="uppercase inline-flex items-center font-semibold text-xs tracking-wide"
                   href="<?php echo is_user_logged_in() ? get_permalink(get_option('woocommerce_myaccount_page_id')) : wc_get_page_permalink('myaccount'); ?>"
                   target="_self">
                    <?php echo is_user_logged_in() ? 'Мой аккаунт' : 'Вход'; ?>
                </a>
                <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                <a class="uppercase inline-flex items-center font-semibold text-xs tracking-wide" href="/" target="_self">
                    избранное (0)
                </a>
            </div>
            <div class="flex xl:hidden btn-burger ml-3">
                <ul class="lines">
                    <li class="line"></li>
                    <li class="line"></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<div class="sub-menu fixed top-[56px] left-0 right-0 w-full bg-white-10 z-50 opacity-0 -translate-y-3 invisible px-4 py-8">
    <?php
    $menu_name = 'header-menu';
    $menu_items = wp_get_nav_menu_items($menu_name);

    if ($menu_items):
        foreach ($menu_items as $key => $item):
            $menus = get_field('add_menus', $item);
            $images = get_field('image_menu', $item);
            $isSabMenu = get_field('is_sabmenu', $item);
            if(!empty($menus) && $isSabMenu): ?>
                <div data-menu-id="<?=$item->ID?>" class="h-0 opacity-0 -translate-y-3 invisible flex custom-submenu justify-between">
                    <div class="w-1/2">
                        <div class="flex gap-4" >
                            <?php foreach ($menus as $menu):?>

                                <div class="max-w-52 w-full">
                                    <h3 class="font-bold text-xs tracking-wide mb-6 uppercase text-black-10"><?=$menu['title']?></h3>
                                    <ul class="menu">
                                        <?php foreach ($menu['items'] as $it):?>
                                            <li class="seb-menu-item"><a href="<?=get_term_link($it->term_id)?>"><?=$it->name?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <div class="flex justify-end gap-2">
                            <?php foreach ($images as $image):?>

                                <div class="relative max-h-80 rounded overflow-hidden">
                                    <img class="w-full h-full object-cover " src="<?=$image['image']?>" alt="<?=get_bloginfo()?>">
                                    <a class="link absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center w-full h-full bg-black-10/40 uppercase text-white-30 font-bold hover:bg-black-10/0 hover:text-[0px] ease transition-all" href="<?=$image['link']['url']?>" target="_self"><span><?=$image['link']['title']?></span></a>
                                </div>

                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            <?php
            endif;
        endforeach;
    endif;
    ?>
</div>




<div class="mobile-menu fixed top-[56px] left-0 right-0 w-full bg-white-10 z-50 opacity-0 -translate-y-3 invisible overflow-x-auto h-full pb-10">
    <div class="px-4 py-8">
        <div class="flex flex-row justify-between gap-4">
            <nav class="flex-1" role="navigation">
                <?php mobile_nav(); ?>
             </nav>
             <div class="flex-1 flex items-end flex-col *:mb-4">
                 <a class="uppercase inline-flex items-center font-semibold text-xs tracking-wide"
                    href="<?php echo is_user_logged_in() ? get_permalink(get_option('woocommerce_myaccount_page_id')) : wc_get_page_permalink('myaccount'); ?>"
                    target="_self">
                     <?php echo is_user_logged_in() ? 'Мой аккаунт' : 'Вход'; ?>
                 </a>
                 <a class="uppercase inline-flex items-center font-semibold text-xs tracking-wide" href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" target="_self">
                     избранное (0)
                 </a>
                 <a class="uppercase inline-flex items-center font-semibold text-xs tracking-wide" href="<?php echo wc_get_cart_url(); ?>" target="_self">
                     Корзина (<span class="align-text-bottom" id="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>)
                 </a>

             </div>

        </div>
        <div id="menu-tabs" class="mt-14">
            <?php
            $menu_name = 'header-menu';
            $menu_items = wp_get_nav_menu_items($menu_name);

            if ($menu_items): ?>
                <div class="menu-titles flex gap-4 mb-10">
                <?php foreach ($menu_items as $key => $item):
                    $menus = get_field('add_menus', $item);
                    $isSabMenu = get_field('is_sabmenu', $item);
                    if (!empty($menus) && $isSabMenu): ?>
                       <h3 class="text-xl font-bold tracking-wide uppercase text-gray-30  menu-title cursor-pointer <?=($key == 0)? 'active': ''?>" data-menu-id="<?=$item->ID?>"><?=$item->post_title?></h3>
                    <?php endif;
                endforeach; ?>
               </div>

                <?php foreach ($menu_items as $key => $item):
                    $menus = get_field('add_menus', $item);
                    $images = get_field('image_menu', $item);
                    $isSabMenu = get_field('is_sabmenu', $item);
                    if (!empty($menus) && $isSabMenu): ?>
                        <div data-menu-id="<?=$item->ID?>" class="menu-content <?= $key === 0 ? '' : 'hidden' ?>">
                            <div class="flex flex-col gap-4 justify-between">
                                <div class="w-full">
                                    <div class="flex gap-4">
                                        <?php foreach ($menus as $menu): ?>
                                            <div class="w-full">
                                                <h3 class="font-bold text-xs tracking-wide mb-6 uppercase text-black-10"><?=$menu['title']?></h3>
                                                <ul class="menu">
                                                    <?php foreach ($menu['items'] as $it): ?>
                                                        <li class="mobile-menu-item"><a href="<?=get_term_link($it->term_id)?>"><?=$it->name?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="w-full">
                                    <div class="flex gap-2">
                                        <?php foreach ($images as $image): ?>
                                            <div class="basis-1/2 relative max-h-[25vmax] rounded overflow-hidden">
                                                <img class="w-full h-full object-cover" src="<?=$image['image']?>" alt="<?=get_bloginfo()?>">
                                                <a class="link absolute top-0 left-0 right-0 bottom-0 flex items-center justify-center w-full h-full bg-black-10/40 uppercase text-white-30 text-xs font-bold hover:bg-black-10/0 hover:text-[0px] ease transition-all" href="<?=$image['link']['url']?>" target="_self"><span><?=$image['link']['title']?></span></a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endif;
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>

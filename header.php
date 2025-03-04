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

<body <?php body_class('flex flex-col min-h-screen antialiased font-reg font-normal leading-normal text-sm xs:text-base text-black selection:bg-black selection:text-white-10'); ?> data-page-id="<?php the_ID(); ?>">
<?php wp_body_open(); ?>

<header class="max-w-full-client-width px-[2.8vmax] top-0 sticky z-40 w-full bg-white backdrop-blur-md overflow-hidden">
    <div class=" flex py-4 gap-y-4 justify-between items-center flex-wrap ">
        <div class="flex gap-x-4 flex-row w-full basis-1/5 md:w-auto md:basis-1/2">
            <nav class="hidden xs:flex flex-row" role="navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                        'menu_class' => 'menu flex flex-row',
                    )
                );
                ?>
            </nav>
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
        <div class="flex justify-end flex-row items-center w-full basis-3/5 md:w-auto md:basis-1/2 twrapper">
            <div class="tcontainer">
                <div class="front flex justify-end flex-row items-center">
                    <div class="flex gap-4 pr-8 md:pr-[15vmax]">
                        <a href="<?php echo wc_get_cart_url(); ?>" target="_self">
                            <div class="text-black flex relative items-center justify-center gap-0">
                                <div class="select-none xs:text-2xl font-medium leading-none" id="cart-count">
                                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                                </div>
                                <svg class="w-6 h-6 xs:w-8 xs:h-8" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4 6.15385C4 5.70069 4.38574 5.33333 4.86157 5.33333H6.45376C7.43117 5.33333 8.28239 5.95944 8.53462 6.85473L8.53498 6.85604L8.80035 7.80423C15.0515 7.69552 21.2909 8.3858 27.3513 9.85737C27.5835 9.91375 27.7805 10.0597 27.8951 10.2601C28.0097 10.4605 28.0315 10.6973 27.9552 10.9136C26.9967 13.6322 25.8579 16.2732 24.5539 18.821C24.4096 19.1031 24.1089 19.2821 23.7794 19.2821H10.8926C10.2071 19.2821 9.54965 19.5414 9.06492 20.003C8.78973 20.2651 8.583 20.5802 8.45569 20.9231H25.5393C26.0152 20.9231 26.4009 21.2904 26.4009 21.7436C26.4009 22.1967 26.0152 22.5641 25.5393 22.5641H7.4463C6.97046 22.5641 6.58472 22.1967 6.58472 21.7436C6.58472 20.6555 7.03858 19.612 7.84647 18.8426C8.39338 18.3218 9.0722 17.9555 9.80816 17.7731L6.87033 7.27997C6.87028 7.27982 6.87037 7.28012 6.87033 7.27997C6.81911 7.09899 6.64793 6.97436 6.45376 6.97436H4.86157C4.38574 6.97436 4 6.607 4 6.15385ZM11.5545 17.641H23.2385C24.28 15.5644 25.2093 13.4256 26.0179 11.2334C20.5306 9.97706 14.9008 9.3743 9.25795 9.43884L11.5545 17.641ZM7.08942 23.8653C7.41257 23.5575 7.85086 23.3846 8.30787 23.3846C8.76487 23.3846 9.20316 23.5575 9.52632 23.8653C9.84947 24.173 10.031 24.5904 10.031 25.0256C10.031 25.4609 9.84947 25.8783 9.52632 26.186C9.20316 26.4938 8.76487 26.6667 8.30787 26.6667C7.85086 26.6667 7.41257 26.4938 7.08942 26.186C6.76627 25.8783 6.58472 25.4609 6.58472 25.0256C6.58472 24.5904 6.76627 24.173 7.08942 23.8653ZM21.7362 23.8653C22.0593 23.5575 22.4976 23.3846 22.9546 23.3846C23.4116 23.3846 23.8499 23.5575 24.1731 23.8653C24.4962 24.173 24.6778 24.5904 24.6778 25.0256C24.6778 25.4609 24.4962 25.8783 24.1731 26.186C23.8499 26.4938 23.4116 26.6667 22.9546 26.6667C22.4976 26.6667 22.0593 26.4938 21.7362 26.186C21.413 25.8783 21.2315 25.4609 21.2315 25.0256C21.2315 24.5904 21.413 24.173 21.7362 23.8653Z" fill="black" />
                                </svg>
                            </div>
                        </a>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" target="_self">
                            <svg class="w-6 h-6 xs:w-8 xs:h-8" width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9999 17.6549C14.2388 17.6549 12.5433 18.3287 11.2804 19.5384C10.1611 20.6105 9.46162 22.0278 9.29617 23.5436C11.3607 24.3778 13.6245 24.8381 15.9999 24.8381L16.0013 24.8381C18.3026 24.8411 20.5802 24.4005 22.7036 23.5434C22.5381 22.0276 21.8386 20.6105 20.7194 19.5384C19.4565 18.3287 17.7611 17.6549 15.9999 17.6549ZM9.91259 18.2511C11.532 16.6999 13.7178 15.8264 15.9999 15.8264C18.282 15.8264 20.4679 16.6999 22.0872 18.2511C23.7059 19.8016 24.6295 21.9046 24.6665 24.1054C24.6725 24.4649 24.4561 24.7944 24.1134 24.9473C21.5688 26.0834 18.8006 26.6703 15.9992 26.6666C13.1052 26.6666 10.3563 26.0513 7.88607 24.9472C7.5436 24.7941 7.32735 24.4647 7.33337 24.1054C7.37029 21.9046 8.29398 19.8016 9.91259 18.2511Z" fill="black" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9998 7.16191C15.2414 7.16191 14.5091 7.45502 13.9652 7.98454C13.4206 8.51485 13.1104 9.23889 13.1104 9.99853C13.1104 10.7582 13.4206 11.4822 13.9652 12.0125C14.5091 12.542 15.2414 12.8352 15.9998 12.8352C16.7582 12.8352 17.4906 12.542 18.0344 12.0125C18.579 11.4822 18.8892 10.7582 18.8892 9.99853C18.8892 9.23889 18.579 8.51485 18.0344 7.98454C17.4906 7.45502 16.7582 7.16191 15.9998 7.16191ZM12.5863 6.70793C13.4874 5.83059 14.7148 5.33333 15.9998 5.33333C17.2848 5.33333 18.5122 5.83059 19.4133 6.70793C20.3135 7.58449 20.8151 8.76857 20.8151 9.99853C20.8151 11.2285 20.3135 12.4126 19.4133 13.2891C18.5122 14.1665 17.2848 14.6637 15.9998 14.6637C14.7148 14.6637 13.4874 14.1665 12.5863 13.2891C11.6861 12.4126 11.1845 11.2285 11.1845 9.99853C11.1845 8.76857 11.6861 7.58449 12.5863 6.70793Z" fill="black" />
                            </svg>
                        </a>
                    </div>
                    <a href="<?=get_home_url()?>" target="_self">
                        LOGO
                    </a>
                </div>
                <nav class="back mobile-menu flex xs:hidden flex-row" role="navigation">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'menu_id'        => 'primary-menu',
                        )
                    );
                    ?>
                </nav>
            </div>
        </div>
    </div>
</header>

<?php
add_action('after_setup_theme', 'blaar_theme_register_nav_menu');
add_filter('walker_nav_menu_start_el', 'blaar_theme_add_caret_to_menu', 10, 4);
add_filter('wp_nav_menu_args', 'my_wp_nav_menu_args');

function blaar_theme_register_nav_menu()
{
    register_nav_menu('header-menu', 'Header Menu');
    register_nav_menu('footer-menu', 'Footer Menu');
    register_nav_menu('mobile-menu', 'Mobile Menu');
}

# Header Menu
function header_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'header-menu',
            'menu' => '',
            'container' => '',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu flex flex-row',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}
function footer_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'footer-menu',
            'menu' => '',
            'container' => '',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu-footer flex flex-col xs:flex-row',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}

function mobile_nav()
{
    wp_nav_menu(
        array(
            'theme_location' => 'mobile-menu',
            'menu' => '',
            'container' => '',
            'container_class' => 'menu-{menu slug}-container',
            'container_id' => '',
            'menu_class' => 'menu-mobile flex flex-col',
            'menu_id' => '',
            'echo' => true,
            'fallback_cb' => 'wp_page_menu',
            'before' => '',
            'after' => '',
            'link_before' => '',
            'link_after' => '',
            'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth' => 0,
            'walker' => ''
        )
    );
}

function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

function blaar_theme_add_caret_to_menu($item_output, $item, $depth, $args) {
    if (in_array('menu-item-has-children', $item->classes)) {
        $item_output .= '<span class="caret"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M11.7348 14.8819L7.117 10.252C6.961 10.126 6.961 9.87402 7.117 9.71654L7.74103 9.11811C7.89704 8.96063 8.11544 8.96063 8.27145 9.11811L12.0156 12.8346L15.7285 9.11811C15.8846 8.96063 16.1342 8.96063 16.259 9.11811L16.883 9.71654C17.039 9.87402 17.039 10.126 16.883 10.252L12.2652 14.8819C12.1092 15.0394 11.8908 15.0394 11.7348 14.8819Z" fill="#7297E0" /></svg></span>';
    }
    return $item_output;
}




<?php
/**
 * Register widget area.
 */

add_action('widgets_init', 'blaar_shop_sidebar');
add_action( 'widgets_init', 'blaar_widgets_init' );

function blaar_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'advocate-theme' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'advocate-theme' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}

function blaar_shop_sidebar() {
    register_sidebar([
        'name'          => 'Сайдбар магазина',
        'id'            => 'shop-sidebar',
        'before_widget' => '<div class="mb-4 p-4 bg-white dark:bg-gray-700 rounded-lg shadow-md">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">',
        'after_title'   => '</h3>',
    ]);
}


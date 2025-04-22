<?php

show_admin_bar( false );

add_action( 'after_setup_theme', 'blaar_theme_setup' );
function blaar_theme_setup() {
    /*
        * Делаем тему доступной для перевода.
        * Файлы переводов должны находиться в папке /languages/.
        * Если используешь другую тему, замени 'blaar-theme' на её имя.
    */
    load_theme_textdomain( 'blaar-theme', get_template_directory() . '/languages' );

    // Добавляет ссылки на RSS-ленты для записей и комментариев в `<head>`
    add_theme_support( 'automatic-feed-links' );

    // Позволяет WordPress управлять заголовком страницы
    add_theme_support( 'title-tag' );

    // Включает поддержку миниатюр (изображений записей)
    add_theme_support( 'post-thumbnails' );

    // Включает поддержку отложенной загрузки изображений (Lazy Load)
    add_theme_support('lazy-load');

    // Включает поддержку WooCommerce блоков в редакторе Gutenberg
    add_theme_support('wc-blocks');


    /*
        * Включает поддержку HTML5 для некоторых элементов,
        * что делает разметку более современной и семантической.
    */
    add_theme_support(
        'html5',
        array(
            'search-form',     // Форма поиска
            'comment-form',    // Форма комментариев
            'comment-list',    // Список комментариев
            'gallery',         // Галереи изображений
            'caption',         // Подписи к изображениям
            'style',           // Подключение стилей через `wp_enqueue_style()`
            'script',          // Подключение скриптов через `wp_enqueue_script()`
        )
    );

    // Позволяет обновлять виджеты без перезагрузки в настройках кастомайзера
    add_theme_support( 'customize-selective-refresh-widgets' );

    /**
     * Включает поддержку кастомного логотипа
     */
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 250,  // Высота логотипа
            'width'       => 250,  // Ширина логотипа
            'flex-width'  => true, // Позволяет изменять ширину
            'flex-height' => true, // Позволяет изменять высоту
        )
    );

    // Включает поддержку меню в теме
    add_theme_support('menus');

    // Включает поддержку  виджетов в теме
//    add_theme_support('widgets');


    // Добавляет кастомные размеры изображений
    add_image_size('small', 300, '', true);    // Маленькое изображение
    add_image_size('medium', 600, '', true);   // Среднее изображение
    add_image_size('large', 1000, '', true);   // Большое изображение
    add_image_size('large2', 1400, '', true);  // Еще большее изображение
    add_image_size('large3', 1920, '', true);  // Полноэкранное изображение
}

add_action('after_setup_theme', 'blaar_theme_setup');


// Remove Wordpress emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');



// ------- для Gutenberg -----------------

//Включает поддержку редактора стилей Gutenberg
function blaar_gutenberg_setup() {
    add_theme_support('wp-block-styles'); // Подключает базовые стили блоков
    add_theme_support('align-wide'); // Поддержка широких и полноразмерных блоков
    add_theme_support('editor-styles'); // Включает стили редактора
}
add_action('after_setup_theme', 'blaar_gutenberg_setup');

function blaar_gutenberg_enqueue_styles() {
    wp_enqueue_style('theme-style', get_stylesheet_uri()); // Стиль темы
    wp_enqueue_style('wp-block-library'); // Базовые стили Gutenberg
}
add_action('wp_enqueue_scripts', 'blaar_gutenberg_enqueue_styles');
// ------- для Gutenberg --------конец---------

?>

<?php

//удаление стандартных хуков из woocommerce_single_product_summary и затем вызрв их отдельно в нужном месте
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
remove_action('woocommerce_single_product_summary', [WC_Structured_Data::class, 'generate_product_data'], 60);
// конец улвдения

// Убирает отображение метки "Скидка" над товаром
//remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

// Отключает блок "С этим товаром покупают" (Upsell товары)
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

// Отключает вывод связанных товаров (Related Products)
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);

// Убирает вкладки с дополнительной информацией (Описание, Характеристики, Отзывы и т. д.)
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

// Убирать стандартное описание
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

// Убирает отображение галереи изображений товара
//remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

// Отключает блок с мета-данными товара (Категории, Метки, SKU)
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);



/// Вывод описание перед кнопкой "В корзину"
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 29);

//удалить кнопку из уведомления при добавлении товара в корзину
add_filter('wc_add_to_cart_message_html', function ($message, $products) {
    return preg_replace('/<a .*?class=".*?wc-forward.*?".*?>.*?<\/a>/', '', $message);
}, 10, 2);

// Удаляет описание вариации + Удаляет доступность вариации
add_filter('woocommerce_available_variation', function ($variations) {
    unset($variations['variation_description']);
//    unset($variations['availability_html']);
    return $variations;
});






// убрать возможность выбора количества на странице товара
add_filter('woocommerce_is_sold_individually', 'blaar_hide_quantity_input_on_single_product', 10, 2);

add_filter('woocommerce_add_error', function ($error) {
    return wp_strip_all_tags($error);
});


function blaar_display_product_attributes() {
    global $product;
    $attributes = $product->get_attributes();

    if (!empty($attributes)) {
        echo '<div class="attributes pt-5">';
        echo '<h3 class="uppercase text-xs 2xl:text-sm font-bold">Характеристики</h3>';
        echo '<table class="w-full mt-6">';
        echo '<tbody>';

        foreach ($attributes as $attribute) {
            echo '<tr class="border-b">';

            // Название атрибута
            echo '<td class="font-medium text-gray-60 pb-3 pt-3">' . wc_attribute_label($attribute->get_name()) . '</td>';

            // Значения атрибута
            if ($attribute->is_taxonomy()) {
                $terms = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                echo '<td>' . implode(', ', $terms) . '</td>';
            } else {
                echo '<td>' . implode(', ', $attribute->get_options()) . '</td>';
            }

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
}

// Отключает выбор количества
function blaar_hide_quantity_input_on_single_product($return, $product) {
    if (is_product()) {
        return true;
    }
    return $return;
}


// custom list image for product-page
function get_product_images() {
    global $product;
    if (!$product) return;

    $images = [];

    if ($product->is_type('simple')) {
        // Основное изображение
        if (has_post_thumbnail()) {
            $images[] = get_the_post_thumbnail_url($product->get_id(), 'full');
        } else {
            $images[] = wc_placeholder_img_src(); // Дефолтное изображение
        }

        // Галерея товара
        $gallery_ids = $product->get_gallery_image_ids();
        foreach ($gallery_ids as $id) {
            $images[] = wp_get_attachment_url($id);
        }
    } elseif ($product->is_type('variable')) {
        // Получаем вариации
        $variations = $product->get_available_variations();

        foreach ($variations as $variation) {
            $variation_id = $variation['variation_id'];
            $image_id = get_post_thumbnail_id($variation_id);
            $gallery_images = get_post_meta($variation_id, 'vargal_params', true);

            // Основное изображение вариации
            if ($image_id) {
                $images[$variation_id][] = wp_get_attachment_url($image_id);
            } elseif (has_post_thumbnail()) {
                $images[$variation_id][] = get_the_post_thumbnail_url($product->get_id(), 'full');
            } else {
                $images[$variation_id][] = wc_placeholder_img_src();
            }

            // Галерея вариации
            if (!empty($gallery_images)) {
                foreach ($gallery_images as $img_id) {
                    $images[$variation_id][] = wp_get_attachment_url($img_id);
                }
            }
        }
    }

    return $images;
}
add_action('wp_ajax_load_variation_images', 'load_variation_images');
add_action('wp_ajax_nopriv_load_variation_images', 'load_variation_images');

//js - при клике на иконки
function load_variation_images() {
    $variation_id = intval($_POST['variation_id']);
    $images = [];

    if ($variation_id) {
        $image_id = get_post_thumbnail_id($variation_id);
        $gallery_images = get_post_meta($variation_id, 'vargal_params', true);

        if ($image_id) {
            $images[] = wp_get_attachment_url($image_id);
        } elseif (has_post_thumbnail()) {
            global $product;
            $images[] = get_the_post_thumbnail_url($product->get_id(), 'full');
        } else {
            $images[] = wc_placeholder_img_src();
        }

        if (!empty($gallery_images)) {
            foreach ($gallery_images as $img_id) {
                $images[] = wp_get_attachment_url($img_id);
            }
        }
    }

    wp_send_json($images);
}
// custom list image for product-page --- end








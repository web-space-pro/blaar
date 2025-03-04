<?php
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

//Вывод Комплектации перед характеристиками ( ACF )
add_action('woocommerce_single_product_summary', 'blaar_display_product_equipment', 24);

// Вывод Атрибутов  перед описанием
add_action('woocommerce_single_product_summary', 'blaar_display_product_attributes', 25);

// Убирать стандартное описание
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// Вывод описание перед кнопкой "В корзину"
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 29);
//удалить кнопку из уведомления при добавлении товара в корзину
add_filter('wc_add_to_cart_message_html', function ($message, $products) {
    return preg_replace('/<a .*?class=".*?wc-forward.*?".*?>.*?<\/a>/', '', $message);
}, 10, 2);
add_filter('woocommerce_add_error', function ($error) {
    return wp_strip_all_tags($error);
});


function blaar_display_product_attributes() {
    global $product;
    $attributes = $product->get_attributes();

    if (!empty($attributes)) {
        echo '<div class="attributes pt-4  border-black">';
        echo '<h3 class="font-sans text-base text-gray-20 mb-4">Характеристики</h3>';
        echo '<table class="w-full font-sans">';
        echo '<tbody>';

        foreach ($attributes as $attribute) {
            echo '<tr class="mb-2">';

            // Название атрибута
            echo '<td class="font-medium text-black">' . wc_attribute_label($attribute->get_name()) . '</td>';

            // Значения атрибута
            if ($attribute->is_taxonomy()) {
                $terms = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                echo '<td class="text-gray-10">' . implode(', ', $terms) . '</td>';
            } else {
                echo '<td class="text-gray-10">' . implode(', ', $attribute->get_options()) . '</td>';
            }

            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    }
}

function blaar_display_product_equipment() {
    global $product;

    // Получаем значения чекбоксов из ACF
    $equipments = get_field('product_equipment', $product->get_id());

    // Проверяем, есть ли данные
    if ($equipments && is_array($equipments)) {
        echo '<div class="equipment mt-8">';
        echo '<div class="custom-select relative w-full">';
        echo '<div class="custom-select-trigger bg-transparent text-gray-20 border-b border-black py-2 text-base flex justify-between items-center cursor-pointer relative">Выберите комплектацию</div>';
        echo '<div class="custom-options absolute top-full left-0 w-full bg-white-10 border border-gray-10 hidden z-10 shadow-md">';

        foreach ($equipments as $equipment) {
            echo '<div class="custom-option px-3 py-2 bg-white-10 text-black text-sm cursor-pointer hover:bg-gray-10 hover:text-white-10 transition">' . esc_html($equipment['label']) . '</div>';
        }

        echo '</div>'; // .custom-options
        echo '<input type="hidden" name="product_equipment">';
        echo '</div>'; // .custom-select
        echo '</div>';
    }
}


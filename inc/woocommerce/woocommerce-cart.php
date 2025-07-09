<?php
// Отображение атрибутов вариативного товара в корзине
add_filter('woocommerce_get_item_data', 'blaar_display_variation_attributes_in_cart', 10, 2);
add_filter('woocommerce_cart_item_name', 'blaar_remove_attribute_from_cart_item_name', 10, 3);


function blaar_display_variation_attributes_in_cart($item_data, $cart_item) {
    // Проверка, что товар вариативный
    if (isset($cart_item['variation'])) {
        foreach ($cart_item['variation'] as $attribute_name => $attribute_value) {
            // Получаем метку атрибута (например, "Цвет" вместо "pa_czvet")
            $taxonomy = str_replace('attribute_', '', $attribute_name);
            $attribute_label = wc_attribute_label($taxonomy);

            // Получаем термин для значения атрибута (например, для "синий")
            if (taxonomy_exists($taxonomy)) {
                // Ищем термин, соответствующий значению, добавленному в корзину
                $terms = wc_get_product_terms($cart_item['product_id'], $taxonomy, array('fields' => 'all'));

                // Ищем термин с нужным значением
                $attribute_value_label = $attribute_value;

                foreach ($terms as $term) {
                    if ($term->slug === $attribute_value) {
                        // Если найден термин, то заменяем значение на имя термина
                        $attribute_value_label = $term->name;
                        break;
                    }
                }
            }


            $item_data[] = array(
                'name'  => $attribute_label,    // Название атрибута
                'value' => $attribute_value_label,    // Локализованное значение атрибута
            );
        }
    }
    return $item_data;
}
function blaar_remove_attribute_from_cart_item_name($product_name, $cart_item, $cart_item_key) {
    $product = $cart_item['data'];
    $product_url = get_permalink($product->get_id());
    $original_product_name = $product->get_name();

    if (str_contains($original_product_name, ' - ')) {
        // Убираем часть текста после " - "
        $product_name = preg_replace('/ - .*/', '', $original_product_name);
    }
    $product_name = '<a href="' . $product_url . '">' . $product_name . '</a>';

    return $product_name;
}











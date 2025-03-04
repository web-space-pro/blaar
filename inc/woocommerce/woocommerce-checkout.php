<?php
add_filter('woocommerce_coupons_enabled', 'blaar_remove_checkout_coupon_field');
add_filter('woocommerce_checkout_fields', 'blaar_checkout_fields');
add_action('wp', 'blaar_remove_order_details_review');

//add_filter('woocommerce_checkout_fields', 'blaar_remove_checkout_sections');
//add_filter('woocommerce_available_payment_gateways', 'blaar_available_payment_gateways');


//Удаление <label> в форме оформления заказа
add_filter('woocommerce_form_field', function($field, $key, $args) {
    if (isset($args['label'])) {
        $field = preg_replace('/<label.*?<\/label>/', '', $field);
    }
    return $field;
}, 10, 3);

function blaar_remove_checkout_coupon_field($enabled) {
    if (is_checkout()) {
        return false;
    }
    return $enabled;
}

function blaar_checkout_fields($fields) {
    // Удаляем все ненужные поля
    unset($fields['billing']['billing_company']);       // Компания
    unset($fields['billing']['billing_address_1']);     // Адрес 1
    unset($fields['billing']['billing_address_2']);     // Адрес 2
    unset($fields['billing']['billing_city']);          // Город
    unset($fields['billing']['billing_state']);         // Регион/Область
    unset($fields['billing']['billing_postcode']);      // Почтовый индекс
    unset($fields['billing']['billing_country']);       // Страна
    unset($fields['billing']['billing_email']);         // Email
    unset($fields['billing']['billing_company']);       // Название компании
    unset($fields['billing']['billing_phone']);         //

    unset($fields['shipping']); //весь блок доставки

    //вывод нужных полей
    $fields['billing'] = array(
        'billing_first_name' => array(
            'label'    => __('ФИО', 'woocommerce'),
            'required' => true,
            'class'    => array('form-row-wide'),
            'placeholder' => __('ФИО', 'woocommerce'),
            'priority' => 10,
        ),
        'billing_phone' => array(
            'label'    => __('Телефон', 'woocommerce'),
            'required' => true,
            'class'    => array('form-row-wide'),
            'placeholder' => __('Телефон', 'woocommerce'),
            'priority' => 20,
        ),
        'order_comments' => array(
            'label'    => __('Комментарий к заказу', 'woocommerce'),
            'type'        => 'textarea',
            'class'       => ['form-row-wide', 'notes'],
            'placeholder' => __('Комментарий к заказу', 'woocommerce'),
            'required'    => false,
            'priority'    => 30
        ),
    );

    return $fields;
}

function blaar_remove_checkout_sections($sections) {
    // Удаляем ненужные блоки
    unset($sections['billing']);    // Убираем ненужные поля биллинга
    unset($sections['shipping']);   // Убираем доставку (если не нужна)
    unset($sections['account']);    // Убираем создание аккаунта
    return $sections;
}

function blaar_available_payment_gateways($gateways) {

//    unset($gateways['cod']); // "Оплата при доставке"
    unset($gateways['paypal']); //  PayPal
    return $gateways;
}

function blaar_remove_order_details_review() {
    remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
}






//function blaar_remove_order_details_thankyou($order_id) {
//    remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
//}
//add_action('wp', 'blaar_remove_order_details_thankyou');





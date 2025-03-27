<?php
require 'my-account/wishlist.php';
function change_dashboard_title( $translated_text, $text, $domain ) {
    // Проверяем, если это текст "Панель управления" из WooCommerce
    if ( 'woocommerce' === $domain && 'Dashboard' === $text ) {
        $translated_text = 'Информация';
    }
    return $translated_text;
}

add_filter( 'gettext', 'change_dashboard_title', 20, 3 );


add_filter( 'woocommerce_account_orders_columns', function( $columns ) {
    $columns['order-number'] = '№ заказа';
    $columns['order-date'] = 'Дата';
    $columns['order-total'] = 'Сумма';
    $columns['order-actions'] = '';
    if (isset($columns['order-status'])) {
        unset($columns['order-status']);
    }

    return $columns;
} );

add_filter( 'woocommerce_my_account_my_orders_actions', function( $actions, $order ) {
//    if ( isset( $actions['pay'] ) ) {
//        $actions['pay']['name'] = 'Оплатить сейчас'; // Изменяем "Оплатить"
//    }
    if ( isset( $actions['view'] ) ) {
        $actions['view']['name'] = 'Подробнее';
    }
//    if ( isset( $actions['cancel'] ) ) {
//        $actions['cancel']['name'] = 'Отменить заказ'; // Изменяем "Отмена"
//    }
    return $actions;
}, 10, 2 );

// Удаляем колонку "Загрузки"
add_filter( 'woocommerce_account_menu_items', function( $items ) {
//    unset( $items['edit-address'] ); // Убирает "Платежные адреса"
    unset( $items['downloads'] ); // Убирает "Загрузки"
    return $items;
} );

function custom_billing_fields_my_account( $fields ) {
    // Убираем ненужные поля
    unset($fields['billing_company']);
    unset($fields['billing_postcode']);
    unset($fields['billing_state']);
    unset($fields['billing_last_name']);

    // Изменяем метки и другие поля для страницы "Мой аккаунт - Редактировать адрес"
    $fields['billing_first_name']['label'] = 'ФИО';
    $fields['billing_first_name']['placeholder'] = '';
    $fields['billing_first_name']['class'] = ['form-row-wide'];
    $fields['billing_first_name']['priority'] = 10;
    $fields['billing_first_name']['required'] = true;

    $fields['billing_phone']['label'] = 'Телефон';
    $fields['billing_phone']['placeholder'] = '';
    $fields['billing_phone']['class'] = ['form-row-wide'];
    $fields['billing_phone']['priority'] = 20;
    $fields['billing_phone']['required'] = true;

    $fields['billing_email']['label'] = 'Email';
    $fields['billing_email']['placeholder'] = '';
    $fields['billing_email']['class'] = ['form-row-wide'];
    $fields['billing_email']['priority'] = 30;
    $fields['billing_email']['required'] = true;

    $fields['billing_city']['label'] = 'Город';
    $fields['billing_city']['placeholder'] = '';
    $fields['billing_city']['class'] = ['form-row-wide'];
    $fields['billing_city']['priority'] = 40;
    $fields['billing_city']['required'] = true;

    $fields['billing_address_1']['label'] = 'Улица';
    $fields['billing_address_1']['placeholder'] = '';
    $fields['billing_address_1']['class'] = ['form-row-wide'];
    $fields['billing_address_1']['priority'] = 50;
    $fields['billing_address_1']['required'] = true;

    $fields['billing_address_2']['label'] = 'Квартира';
    $fields['billing_address_2']['placeholder'] = '';
    $fields['billing_address_2']['class'] = ['form-row-wide'];
    $fields['billing_address_2']['priority'] = 60;
//    $fields['billing_address_2']['required'] = true;

    return $fields;
}
add_filter( 'woocommerce_billing_fields', 'custom_billing_fields_my_account' );

add_filter( 'woocommerce_default_address_fields' , 'override_default_address_fields' );
function override_default_address_fields( $address_fields ) {


    $address_fields['city']['label'] = __('City', 'woocommerce');
    $address_fields['address_1']['placeholder'] = '';

    $address_fields['address_2']['label'] = 'Квартира';
    $address_fields['address_2']['class'] = array('test');
    $address_fields['address_2']['placeholder'] = '';


    return $address_fields;
}
add_filter( 'woocommerce_form_field', 'remove_screen_reader_text_from_labels', 10, 4 );
function remove_screen_reader_text_from_labels( $field, $key, $args, $value ) {
    // Убираем класс 'screen-reader-text' из label
    if ( isset( $args['label'] ) ) {
        $field = str_replace( 'class="screen-reader-text"', '', $field );
    }
    return $field;
}

//  Форма на странице /my-account/edit-account/
add_filter('gettext', 'change_edit_account_title', 20, 3);
function change_edit_account_title($translated_text, $text, $domain)
{
    if ($text === 'Account details' && $domain === 'woocommerce') {
        $translated_text = 'Профиль';
    }
    return $translated_text;
}

// Add field

function blaar_add_field_edit_account_form() {
    woocommerce_form_field(
        'billing_phone', // Используем стандартное поле WooCommerce
        array(
            'type'        => 'tel',
            'required'    => true,
            'label'       => 'Телефон',
            'priority'    => 25,
        ),
        get_user_meta( get_current_user_id(), 'billing_phone', true ) // Берем данные из биллинга
    );
}
//add_action( 'woocommerce_edit_account_form', 'blaar_add_field_edit_account_form' , 15);

// Сохранение данных
function blaar_save_account_details( $user_id ) {
    if (isset($_POST['billing_phone'])) {
        update_user_meta($user_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
}
add_action( 'woocommerce_save_account_details', 'blaar_save_account_details' );


add_filter('woocommerce_save_account_details_required_fields', 'wc_save_account_details_required_fields' );
function wc_save_account_details_required_fields( $required_fields ){
    unset($required_fields['account_display_name'] );
    unset($required_fields['account_first_name']);
    unset($required_fields['account_last_name']);

    return $required_fields;
}




//function custom_shipping_fields_my_account( $fields ) {
//    // Убираем ненужные поля
//    unset($fields['shipping_company']);
//    unset($fields['shipping_address_2']);
//    unset($fields['shipping_postcode']);
//    unset($fields['shipping_state']);
//    unset($fields['shipping_country']);
//    unset($fields['shipping_last_name']);
//
//    // Оставляем и переименовываем нужные поля
//    $fields['shipping_first_name']['label'] = 'ФИО';
//    $fields['shipping_first_name']['class'] = ['form-row-wide'];
//    $fields['shipping_phone'] = [
//        'label' => 'Телефон',
//        'required' => false,
//        'class' => ['form-row-wide'],
//        'priority' => 20,
//    ];
//    $fields['shipping_email'] = [
//        'label' => 'Email',
//        'required' => false,
//        'class' => ['form-row-wide'],
//        'priority' => 30,
//    ];
//    $fields['shipping_city']['label'] = 'Город';
//    $fields['shipping_city']['class'] = ['form-row-wide'];
//    $fields['shipping_address_1']['label'] = 'Улица';
//    $fields['shipping_address_1']['class'] = ['form-row-wide'];
//
//    // Добавляем поле "Квартира"
//    $fields['shipping_apartment'] = [
//        'label' => 'Квартира',
//        'required' => false,
//        'class' => ['form-row-wide'],
//        'priority' => 60,
//    ];
//
//    // Добавляем поле "Способ доставки"
//    $fields['shipping_shipping_method'] = [
//        'label' => 'Способ доставки',
//        'type' => 'select',
//        'options' => [
//            'courier' => 'Курьер',
//            'pickup' => 'Самовывоз',
//        ],
//        'required' => false,
//        'class' => ['form-row-wide'],
//        'priority' => 70,
//    ];
//
//    return $fields;
//}
////add_filter( 'woocommerce_shipping_fields', 'custom_shipping_fields_my_account' );
//
//function save_custom_shipping_fields( $user_id ) {
//    if ( isset( $_POST['shipping_apartment'] ) ) {
//        update_user_meta( $user_id, 'shipping_apartment', sanitize_text_field( $_POST['shipping_apartment'] ) );
//    }
//    if ( isset( $_POST['shipping_shipping_method'] ) ) {
//        update_user_meta( $user_id, 'shipping_shipping_method', sanitize_text_field( $_POST['shipping_shipping_method'] ) );
//    }
//}
////add_action( 'woocommerce_customer_save_address', 'save_custom_shipping_fields' );
//
//

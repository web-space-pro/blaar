<?php
//текст кнопки "Подтвердить заказ"
add_filter('woocommerce_order_button_text', function() {
    return 'Перейти к оплате';
});

//Скрываем чекаут, если корзина пустая
add_action('wp_footer', function() {
    ?>
    <script>
        jQuery(document).ready(function($) {
            function toggleCheckout() {
                if ($('.cart-empty').length) {
                    $('body').addClass('empty-cart');
                } else {
                    $('body').removeClass('empty-cart');
                }
            }
            toggleCheckout();
            $(document.body).on('updated_cart_totals', toggleCheckout);
        });
    </script>

    <script>
        jQuery(function($) {
            $('body').on('change', '.qty', function() {
                $('[name="update_cart"]').trigger('click');
            });
        });
    </script>
    <?php
});


//настраиваем поля формы
add_filter('woocommerce_checkout_fields', function ($fields) {
    // Убираем ненужные стандартные поля
//  unset( $fields['shipping'] );
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_last_name']);

    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);
    unset($fields['shipping']['shipping_postcode']);
    unset($fields['shipping']['shipping_state']);
    unset($fields['shipping']['shipping_country']);
    unset($fields['shipping']['shipping_last_name']);
    unset($fields['order']['order_comments']);

    // Переименовываем стандартные поля и задаем приоритеты
    $fields['billing']['billing_first_name']['label'] = 'ФИО';
    $fields['billing']['billing_first_name']['placeholder'] = '';
    $fields['billing']['billing_first_name']['class'] = ['form-row-wide'];
    $fields['billing']['billing_first_name']['priority'] = 10;

    // ФИО (сливаем имя и фамилию)
    $fields['shipping']['shipping_first_name'] = [
        'label' => 'ФИО',
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 10,
    ];

    $fields['billing']['billing_phone']['label'] = 'Телефон';
    $fields['billing']['billing_phone']['placeholder'] = '';
    $fields['billing']['billing_phone']['priority'] = 20;

    $fields['shipping']['shipping_phone'] = [
        'label' => 'Телефон',
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 20,
    ];

    $fields['billing']['billing_email']['label'] = 'Email';
    $fields['billing']['billing_email']['placeholder'] = '';
    $fields['billing']['billing_email']['priority'] = 30;

    $fields['shipping']['shipping_email'] = [
        'label' => 'Email',
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 30,
    ];

    $fields['billing']['billing_city']['label'] = 'Город';
    $fields['billing']['billing_city']['placeholder'] = '';
    $fields['billing']['billing_city']['priority'] = 40;

    $fields['shipping']['shipping_city'] = [
        'label' => 'Город',
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 40,
    ];

    $fields['billing']['billing_address_1']['label'] = 'Улица';
    $fields['billing']['billing_address_1']['placeholder'] = '';
    $fields['billing']['billing_address_1']['priority'] = 50;

    $fields['shipping']['shipping_address_1'] = [
        'label' => 'Улица',
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 50,
    ];



    // Добавляем поле "Квартира"
    $fields['billing']['billing_apartment'] = [
        'label' => 'Квартира',
        'required' => true,
        'class' => ['form-row-wide'],
        'clear' => true,
        'priority' => 60,
    ];

    $fields['shipping']['shipping_apartment'] = [
        'label' => 'Квартира',
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 60,
    ];


    // Добавляем поле "Способ доставки"
    $fields['billing']['billing_shipping_method'] = [
        'label' => 'Способ доставки',
        'type' => 'select',
        'options' => [
            'courier' => 'Курьер',
            'pickup' => 'Самовывоз',
        ],
        'required' => true,
        'class' => ['form-row-wide shipping_method'],
        'priority' => 70,
    ];

    $fields['shipping']['shipping_shipping_method'] = [
        'label' => 'Способ доставки',
        'type' => 'select',
        'options' => [
            'courier' => 'Курьер',
            'pickup' => 'Самовывоз',
        ],
        'required' => false,
        'class' => ['form-row-wide'],
        'priority' => 70,
    ];

    $fields['billing']['billing_comments'] = [
        'placeholder' => 'Комментарий к заказу',
        'type' => 'textarea',
        'required' => false,
        'class' => ['form-row-wide row-textarea'],
        'priority' => 80,
    ];

    // Комментарий к заказу
//    $fields['order']['order_comments']['placeholder'] = 'Комментарий к заказу';
//    $fields['order']['order_comments']['priority'] = 80;

    return $fields;
});

//сохраняем поля формы
add_action('woocommerce_checkout_update_order_meta', function ($order_id) {
    if (!empty($_POST['billing_phone'])) {
        update_post_meta($order_id, 'billing_phone', sanitize_text_field($_POST['billing_phone']));
    }
    if (!empty($_POST['billing_email'])) {
        update_post_meta($order_id, 'billing_email', sanitize_text_field($_POST['billing_email']));
    }
    if (!empty($_POST['billing_city'])) {
        update_post_meta($order_id, 'billing_city', sanitize_text_field($_POST['billing_city']));
    }
    if (!empty($_POST['billing_address_1'])) {
        update_post_meta($order_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']));
    }
    if (!empty($_POST['billing_apartment'])) {
        update_post_meta($order_id, 'billing_apartment', sanitize_text_field($_POST['billing_apartment']));
    }
    if (!empty($_POST['billing_shipping_method'])) {
        update_post_meta($order_id, 'billing_shipping_method', sanitize_text_field($_POST['billing_shipping_method']));
    }
    if (!empty($_POST['billing_comments'])) {
        update_post_meta($order_id, 'billing_comments', sanitize_text_field($_POST['billing_comments']));
    }

    // Сохраняем данные для shipping
    if (!empty($_POST['shipping_full_name'])) {
        update_post_meta($order_id, 'shipping_full_name', sanitize_text_field($_POST['shipping_full_name']));
    }
    if (!empty($_POST['shipping_phone'])) {
        update_post_meta($order_id, 'shipping_phone', sanitize_text_field($_POST['shipping_phone']));
    }
    if (!empty($_POST['shipping_email'])) {
        update_post_meta($order_id, 'shipping_email', sanitize_text_field($_POST['shipping_email']));
    }
    if (!empty($_POST['shipping_city'])) {
        update_post_meta($order_id, 'shipping_city', sanitize_text_field($_POST['shipping_city']));
    }
    if (!empty($_POST['shipping_address_1'])) {
        update_post_meta($order_id, 'shipping_address_1', sanitize_text_field($_POST['shipping_address_1']));
    }
    if (!empty($_POST['shipping_apartment'])) {
        update_post_meta($order_id, 'shipping_apartment', sanitize_text_field($_POST['shipping_apartment']));
    }
    if (!empty($_POST['shipping_shipping_method'])) {
        update_post_meta($order_id, 'shipping_shipping_method', sanitize_text_field($_POST['shipping_shipping_method']));
    }
    if (!empty($_POST['shipping_comments'])) {
        update_post_meta($order_id, 'shipping_comments', sanitize_text_field($_POST['shipping_comments']));
    }
});

//отобраденеи в звказах
add_action('woocommerce_admin_order_data_after_billing_address', function ($order) {
    // Выводим данные из billing
    $full_name = get_post_meta($order->get_id(), 'billing_full_name', true);
    $phone = get_post_meta($order->get_id(), 'billing_phone', true);
    $email = get_post_meta($order->get_id(), 'billing_email', true);
    $city = get_post_meta($order->get_id(), 'billing_city', true);
    $address_1 = get_post_meta($order->get_id(), 'billing_address_1', true);
    $apartment = get_post_meta($order->get_id(), 'billing_apartment', true);
    $shipping_method = get_post_meta($order->get_id(), 'billing_shipping_method', true);
    $comments = get_post_meta($order->get_id(), 'billing_comments', true);

    if ($phone) {
        echo '<p><strong>Телефон:</strong> ' . esc_html($phone) . '</p>';
    }
    if ($email) {
        echo '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
    }
    if ($city) {
        echo '<p><strong>Город:</strong> ' . esc_html($city) . '</p>';
    }
    if ($address_1) {
        echo '<p><strong>Улица:</strong> ' . esc_html($address_1) . '</p>';
    }
    if ($apartment) {
        echo '<p><strong>Квартира:</strong> ' . esc_html($apartment) . '</p>';
    }
    if ($shipping_method) {
        echo '<p><strong>Способ доставки:</strong> ' . esc_html($shipping_method) . '</p>';
    }
    if ($comments) {
        echo '<p><strong>Комментарий к заказу:</strong> ' . esc_html($comments) . '</p>';
    }

});
//отобраденеи в звказах
add_action('woocommerce_admin_order_data_after_shipping_address', function ($order) {
    $full_name = get_post_meta($order->get_id(), 'shipping_full_name', true);
    $phone = get_post_meta($order->get_id(), 'shipping_phone', true);
    $email = get_post_meta($order->get_id(), 'shipping_email', true);
    $city = get_post_meta($order->get_id(), 'shipping_city', true);
    $address_1 = get_post_meta($order->get_id(), 'shipping_address_1', true);
    $apartment = get_post_meta($order->get_id(), 'shipping_apartment', true);
    $shipping_method = get_post_meta($order->get_id(), 'shipping_shipping_method', true);
    $comments = get_post_meta($order->get_id(), 'shipping_comments', true);

    // Выводим данные в админке
    if ($full_name) {
        echo '<p><strong>ФИО:</strong> ' . esc_html($full_name) . '</p>';
    }
    if ($phone) {
        echo '<p><strong>Телефон:</strong> ' . esc_html($phone) . '</p>';
    }
    if ($email) {
        echo '<p><strong>Email:</strong> ' . esc_html($email) . '</p>';
    }
    if ($city) {
        echo '<p><strong>Город:</strong> ' . esc_html($city) . '</p>';
    }
    if ($address_1) {
        echo '<p><strong>Улица:</strong> ' . esc_html($address_1) . '</p>';
    }
    if ($apartment) {
        echo '<p><strong>Квартира:</strong> ' . esc_html($apartment) . '</p>';
    }
    if ($shipping_method) {
        echo '<p><strong>Способ доставки:</strong> ' . esc_html($shipping_method) . '</p>';
    }
    if ($comments) {
        echo '<p><strong>Комментарий к заказу:</strong> ' . esc_html($comments) . '</p>';
    }
});

//Регистрация новых пользователей при заказе
add_action( 'woocommerce_checkout_process', function() {
    if ( ! is_user_logged_in() ) {
        $email = isset( $_POST['billing_email'] ) ? sanitize_email( $_POST['billing_email'] ) : '';

        if ( email_exists( $email ) ) {
            wc_add_notice( 'Этот email уже зарегистрирован. Пожалуйста, войдите в свою учетную запись.', 'error' );
        } else {
            $username = sanitize_user( current( explode( '@', $email ) ) ); // Создание логина из email
            $password = wp_generate_password();
            $user_id  = wp_create_user( $username, $password, $email );

            if ( ! is_wp_error( $user_id ) ) {
                wc_set_customer_auth_cookie( $user_id ); // Автоматический вход
            }
        }
    }
} );

//remove_action( 'woocommerce_checkout_login_form', 'woocommerce_checkout_login_form', 10 );



remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
add_filter('woocommerce_order_review_heading', '__return_empty_string');
//remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30);





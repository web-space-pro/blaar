<?php
// Определяем путь к JSON-файлу
define('ACF_SYNC_DIR', get_template_directory() . '/acf_sync');
define('ACF_SYNC_FILE', ACF_SYNC_DIR . '/acfconfig.json');

/**
 * Проверяет ACF-поля и статус плагина ACF во время установки темы
 */
function check_acf_before_install() {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');

    $acf_active = is_plugin_active('advanced-custom-fields-pro/acf.php') ||
        is_plugin_active('advanced-custom-fields/acf.php');

    if (!$acf_active) {
        set_transient('acf_plugin_warning', true, 60);
    }

    if (function_exists('acf_get_field_groups')) {
        $existing_groups = acf_get_field_groups();
        if (!empty($existing_groups)) {
            set_transient('acf_backup_warning', true, 60);
        }
    }

    // Если установка идет через загрузку файла, добавляем редирект
    if (isset($_GET['action']) && $_GET['action'] === 'install-theme') {
        wp_safe_redirect(admin_url('themes.php?acf_notice=1'));
        exit;
    }
}
add_action('after_switch_theme', 'check_acf_before_install');

/**
 * Показывает предупреждения на странице "Темы" после установки
 */
function show_acf_warnings_after_install() {
    if (get_transient('acf_plugin_warning')) {
        echo '<div class="notice notice-error is-dismissible">
                <p><strong>Ошибка:</strong> Для корректной работы темы требуется плагин 
                <a href="https://www.advancedcustomfields.com" target="_blank">Advanced Custom Fields (ACF)</a>. 
                Установите и активируйте его в разделе <a href="' . admin_url('plugins.php') . '">Плагины</a>.</p>
              </div>';
        delete_transient('acf_plugin_warning');
    }

    if (get_transient('acf_backup_warning')) {
        echo '<div class="notice notice-warning is-dismissible">
                <p><strong>Внимание:</strong> У вас уже есть ACF-поля в системе. <br> 
                <strong>Импорт может изменить или добавить новые ACF-поля!</strong> <br>
                Рекомендуем сделать резервную копию базы данных перед активацией темы.</p>
              </div>';
        delete_transient('acf_backup_warning');
    }
}
add_action('admin_notices', 'show_acf_warnings_after_install');

/**
 * Импортирует ACF из JSON при активации темы
 */
function import_acf_from_json() {
    if (!function_exists('acf_import_field_group')) {
        error_log('[ACF Import] ACF PRO не активирован — импорт невозможен.');
        return;
    }

    if (!file_exists(ACF_SYNC_FILE)) {
        error_log('[ACF Import] Файл acfconfig.json не найден.');
        return;
    }

    $json_data = file_get_contents(ACF_SYNC_FILE);
    $acf_data = json_decode($json_data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('[ACF Import] Ошибка в JSON: ' . json_last_error_msg());
        return;
    }

    if (empty($acf_data['field_groups'])) {
        error_log('[ACF Import] В JSON нет групп полей.');
        return;
    }

    if (!function_exists('acf_get_field_groups')) {
        error_log('[ACF Import] Функция acf_get_field_groups недоступна.');
        return;
    }

    $existing_groups = acf_get_field_groups();
    $existing_keys = array_column($existing_groups, 'key');

    foreach ($acf_data['field_groups'] as $group) {
        if (!isset($group['key'], $group['title'], $group['fields'])) {
            error_log('[ACF Import] Группа полей пропущена из-за некорректного формата.');
            continue;
        }

        if (in_array($group['key'], $existing_keys)) {
            if (function_exists('acf_update_field_group')) {
                acf_update_field_group($group);
            } else {
                error_log('[ACF Import] Функция acf_update_field_group недоступна.');
            }
        } else {
            acf_import_field_group($group);
        }
    }

    if (!empty($acf_data['options_pages']) && function_exists('acf_add_options_page')) {
        update_option('acf_options_pages', $acf_data['options_pages']);
        foreach ($acf_data['options_pages'] as $page) {
            acf_add_options_page($page);
        }
    }

    add_action('admin_notices', function () {
        echo '<div class="notice notice-success">
                <p><strong>Успех:</strong> Поля ACF и страницы настроек успешно импортированы.</p>
              </div>';
    });
}

add_action('admin_init', 'import_acf_from_json');

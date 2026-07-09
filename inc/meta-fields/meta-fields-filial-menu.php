<?php
/**
 * Функционал для привязки меню к записям типа "filial"
 * Исправленная версия с гарантированным выводом на фронтенде
 */

// 1. Создание метабокса с выбором меню
add_action('add_meta_boxes', 'filial_menu_meta_box');
function filial_menu_meta_box() {
    add_meta_box(
        'filial_menu_box',
        'Выбор меню для филиала',
        'filial_menu_meta_box_callback',
        'filial',
        'side',
        'default'
    );
}

function filial_menu_meta_box_callback($post) {
    wp_nonce_field('filial_menu_nonce', 'filial_menu_nonce_field');
    
    $selected_menu = get_post_meta($post->ID, '_filial_selected_menu', true);
    $menus = wp_get_nav_menus();
    
    if (empty($menus)) {
        echo '<p>Меню не найдены. Создайте меню в <a href="' . admin_url('nav-menus.php') . '">разделе меню</a>.</p>';
        return;
    }
    ?>
    <p>
        <label for="filial_menu_select">Выберите меню для этого филиала:</label>
        <select id="filial_menu_select" name="filial_menu_select" style="width:100%; margin-top: 8px;">
            <option value="">— Стандартное меню —</option>
            <?php foreach ($menus as $menu) : ?>
                <option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($selected_menu, $menu->term_id); ?>>
                    <?php echo esc_html($menu->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <?php
}

// 2. Сохранение выбранного меню
add_action('save_post', 'save_filial_menu');
function save_filial_menu($post_id) {
    if (!isset($_POST['filial_menu_nonce_field'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['filial_menu_nonce_field'], 'filial_menu_nonce')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (get_post_type($post_id) !== 'filial') {
        return;
    }
    
    if (isset($_POST['filial_menu_select']) && !empty($_POST['filial_menu_select'])) {
        $menu_id = intval($_POST['filial_menu_select']);
        update_post_meta($post_id, '_filial_selected_menu', $menu_id);
    } else {
        delete_post_meta($post_id, '_filial_selected_menu');
    }
}

// 3. ГЛАВНАЯ ФУНКЦИЯ для получения меню филиала (РАБОТАЕТ В ЛЮБОМ КОНТЕКСТЕ)
function get_filial_menu_id($post_id = null) {
    // Если ID не передан, пытаемся определить автоматически
    if (!$post_id) {
        // Сначала пробуем получить ID из глобального объекта
        global $post;
        
        if ($post && isset($post->ID) && $post->post_type === 'filial') {
            $post_id = $post->ID;
        } else {
            // Если глобальный объект не подходит, пробуем получить ID из запроса
            $queried_object = get_queried_object();
            if ($queried_object && isset($queried_object->ID) && $queried_object->post_type === 'filial') {
                $post_id = $queried_object->ID;
            }
        }
    }
    
    if (!$post_id) {
        return false;
    }
    
    // Получаем ID меню
    $menu_id = get_post_meta($post_id, '_filial_selected_menu', true);
    
    // Проверяем, существует ли меню
    if (!empty($menu_id) && wp_get_nav_menu_object($menu_id)) {
        return $menu_id;
    }
    
    return false;
}

// 4. Функция для вывода меню филиала (ГАРАНТИРОВАННО РАБОТАЕТ)
function display_filial_menu($args = array()) {
    // Получаем ID меню
    $menu_id = get_filial_menu_id();
    
    if (!$menu_id) {
        return false;
    }
    
    $default_args = array(
        'menu' => $menu_id,
        'menu_class' => 'filial-menu',
        'container' => 'nav',
        'container_class' => 'filial-menu-container',
        'echo' => true,
        'fallback_cb' => false,
        'depth' => 2
    );
    
    $args = wp_parse_args($args, $default_args);
    
    wp_nav_menu($args);
    
    return true;
}

// 5. Функция для получения HTML меню (для использования в переменных)
function get_filial_menu_html($args = array()) {
    $menu_id = get_filial_menu_id();
    
    if (!$menu_id) {
        return '';
    }
    
    $default_args = array(
        'menu' => $menu_id,
        'menu_class' => 'filial-menu',
        'container' => 'nav',
        'container_class' => 'filial-menu-container',
        'echo' => false,
        'fallback_cb' => false,
        'depth' => 2
    );
    
    $args = wp_parse_args($args, $default_args);
    
    return wp_nav_menu($args);
}

// 6. Шорткод для вывода меню
add_shortcode('filial_menu', 'filial_menu_shortcode');
function filial_menu_shortcode($atts) {
    $menu_id = get_filial_menu_id();
    
    if (!$menu_id) {
        return '<p class="filial-menu-error">Для этого филиала не выбрано меню</p>';
    }
    
    $args = shortcode_atts(array(
        'menu' => $menu_id,
        'container' => 'nav',
        'container_class' => 'filial-menu-shortcode',
        'menu_class' => 'menu',
        'echo' => false,
        'fallback_cb' => false
    ), $atts);
    
    return wp_nav_menu($args);
}

// 7. Колонка в админке
add_filter('manage_filial_posts_columns', 'add_filial_menu_column');
function add_filial_menu_column($columns) {
    $columns['filial_menu'] = 'Привязанное меню';
    return $columns;
}

add_action('manage_filial_posts_custom_column', 'display_filial_menu_column', 10, 2);
function display_filial_menu_column($column, $post_id) {
    if ($column === 'filial_menu') {
        $menu_id = get_post_meta($post_id, '_filial_selected_menu', true);
        if (!empty($menu_id)) {
            $menu = wp_get_nav_menu_object($menu_id);
            if ($menu) {
                echo '<a href="' . admin_url('nav-menus.php?action=edit&menu=' . $menu_id) . '" target="_blank">' . esc_html($menu->name) . '</a>';
            } else {
                echo 'Меню удалено';
            }
        } else {
            echo '—';
        }
    }
}
<?php
/**
 * Мета-бокс с дополнительными полями для филиалов
 */

// 1. Регистрация мета-бокса
add_action('add_meta_boxes', 'filial_contact_info_meta_box');
function filial_contact_info_meta_box() {
    add_meta_box(
        'filial_contact_info',
        'Контактная информация филиала',
        'filial_contact_info_meta_box_callback',
        'filial',
        'normal',
        'high'
    );
}

// 2. Callback-функция для вывода полей
function filial_contact_info_meta_box_callback($post) {
    // Nonce для безопасности
    wp_nonce_field('filial_contact_info_nonce', 'filial_contact_info_nonce_field');
    
    // Получаем сохраненные значения
    $appointment_url = get_post_meta($post->ID, '_filial_appointment_url', true);
    $gis2_url = get_post_meta($post->ID, '_filial_gis2_url', true);
    $address = get_post_meta($post->ID, '_filial_address', true);
    $work_schedule = get_post_meta($post->ID, '_filial_work_schedule', true);
    $phone = get_post_meta($post->ID, '_filial_phone', true);
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="filial_appointment_url">Ссылка для записи</label>
            </th>
            <td>
                <input type="url" 
                       id="filial_appointment_url" 
                       name="filial_appointment_url" 
                       value="<?php echo esc_url($appointment_url); ?>" 
                       placeholder="https://example.com/appointment" 
                       style="width: 100%; max-width: 500px;" />
                <p class="description">Введите URL-адрес страницы для записи</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="filial_gis2_url">Ссылка на 2ГИС</label>
            </th>
            <td>
                <input type="url" 
                       id="filial_gis2_url" 
                       name="filial_gis2_url" 
                       value="<?php echo esc_url($gis2_url); ?>" 
                       placeholder="https://2gis.ru/..." 
                       style="width: 100%; max-width: 500px;" />
                <p class="description">Ссылка на профиль организации в 2ГИС</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="filial_address">Адрес</label>
            </th>
            <td>
                <input type="text" 
                       id="filial_address" 
                       name="filial_address" 
                       value="<?php echo esc_attr($address); ?>" 
                       placeholder="г. Москва, ул. Примерная, д. 1" 
                       style="width: 100%; max-width: 500px;" />
                <p class="description">Фактический адрес филиала</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="filial_work_schedule">График работы</label>
            </th>
            <td>
                <input type="text" 
                       id="filial_work_schedule" 
                       name="filial_work_schedule" 
                       value="<?php echo esc_attr($work_schedule); ?>" 
                       placeholder="Пн-Пт: 09:00-20:00, Сб: 10:00-18:00" 
                       style="width: 100%; max-width: 500px;" />
                <p class="description">Режим работы филиала</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="filial_phone">Номер телефона</label>
            </th>
            <td>
                <input type="tel" 
                       id="filial_phone" 
                       name="filial_phone" 
                       value="<?php echo esc_attr($phone); ?>" 
                       placeholder="+7 (999) 123-45-67" 
                       style="width: 100%; max-width: 500px;" />
                <p class="description">Контактный телефон филиала</p>
            </td>
        </tr>
    </table>
    
    <?php
}

// 3. Сохранение данных
add_action('save_post', 'save_filial_contact_info');
function save_filial_contact_info($post_id) {
    // Проверка nonce
    if (!isset($_POST['filial_contact_info_nonce_field'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['filial_contact_info_nonce_field'], 'filial_contact_info_nonce')) {
        return;
    }
    
    // Проверка автосохранения
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Проверка прав
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Проверка типа записи
    if (get_post_type($post_id) !== 'filial') {
        return;
    }
    
    // Массив полей для сохранения
    $fields = array(
        'filial_appointment_url' => '_filial_appointment_url',
        'filial_gis2_url' => '_filial_gis2_url',
        'filial_address' => '_filial_address',
        'filial_work_schedule' => '_filial_work_schedule',
        'filial_phone' => '_filial_phone'
    );
    
    foreach ($fields as $field_name => $meta_key) {
        if (isset($_POST[$field_name])) {
            $value = sanitize_text_field($_POST[$field_name]);
            
            // Для URL-полей используем esc_url_raw
            if (strpos($field_name, 'url') !== false) {
                $value = esc_url_raw($value);
            }
            
            if (!empty($value)) {
                update_post_meta($post_id, $meta_key, $value);
            } else {
                delete_post_meta($post_id, $meta_key);
            }
        }
    }
}

// 4. Добавление колонок в админке
add_filter('manage_filial_posts_columns', 'add_filial_contact_columns');
function add_filial_contact_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['filial_phone'] = 'Телефон';
            $new_columns['filial_address'] = 'Адрес';
        }
    }
    
    return $new_columns;
}

add_action('manage_filial_posts_custom_column', 'display_filial_contact_columns', 10, 2);
function display_filial_contact_columns($column, $post_id) {
    switch ($column) {
        case 'filial_phone':
            $phone = get_post_meta($post_id, '_filial_phone', true);
            if (!empty($phone)) {
                echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'filial_address':
            $address = get_post_meta($post_id, '_filial_address', true);
            echo !empty($address) ? esc_html($address) : '—';
            break;
    }
}

// 5. Функции-помощники для вывода на фронтенде
function get_filial_appointment_url($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_filial_appointment_url', true);
}

function get_filial_gis2_url($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_filial_gis2_url', true);
}

function get_filial_address($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_filial_address', true);
}

function get_filial_work_schedule($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_filial_work_schedule', true);
}

function get_filial_phone($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_filial_phone', true);
}

// 6. Пример вывода всех контактов филиала (для использования в шаблоне)
function display_filial_contacts($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $phone = get_filial_phone($post_id);
    $address = get_filial_address($post_id);
    $schedule = get_filial_work_schedule($post_id);
    $appointment_url = get_filial_appointment_url($post_id);
    $gis2_url = get_filial_gis2_url($post_id);
    
    $output = '<div class="filial-contacts">';
    
    if (!empty($phone)) {
        $output .= '<div class="filial-contact-item">';
        $output .= '<span class="contact-label">Телефон:</span>';
        $output .= '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
        $output .= '</div>';
    }
    
    if (!empty($address)) {
        $output .= '<div class="filial-contact-item">';
        $output .= '<span class="contact-label">Адрес:</span>';
        $output .= '<span class="contact-value">' . esc_html($address) . '</span>';
        $output .= '</div>';
    }
    
    if (!empty($schedule)) {
        $output .= '<div class="filial-contact-item">';
        $output .= '<span class="contact-label">Режим работы:</span>';
        $output .= '<span class="contact-value">' . esc_html($schedule) . '</span>';
        $output .= '</div>';
    }
    
    if (!empty($appointment_url)) {
        $output .= '<div class="filial-contact-item">';
        $output .= '<a href="' . esc_url($appointment_url) . '" class="filial-appointment-btn">Записаться</a>';
        $output .= '</div>';
    }
    
    if (!empty($gis2_url)) {
        $output .= '<div class="filial-contact-item">';
        $output .= '<a href="' . esc_url($gis2_url) . '" target="_blank" rel="noopener noreferrer" class="filial-gis2-link">На карте 2ГИС</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
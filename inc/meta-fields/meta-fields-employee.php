<?php
/**
 * Мета-бокс для сотрудников (employee)
 */

// 1. Регистрация мета-бокса
add_action('add_meta_boxes', 'employee_meta_box');
function employee_meta_box() {
    add_meta_box(
        'employee_info',
        'Информация о сотруднике',
        'employee_meta_box_callback',
        'employee',
        'normal',
        'high'
    );
}

// 2. Callback-функция для вывода полей
function employee_meta_box_callback($post) {
    // Nonce для безопасности
    wp_nonce_field('employee_info_nonce', 'employee_info_nonce_field');
    
    // Получаем сохраненные значения
    $position = get_post_meta($post->ID, '_employee_position', true);
    $phone = get_post_meta($post->ID, '_employee_phone', true);
    $appointment_link = get_post_meta($post->ID, '_employee_appointment_link', true);
    $reviews_link = get_post_meta($post->ID, '_employee_reviews_link', true);
    $filial_id = get_post_meta($post->ID, '_employee_filial_id', true);
    
    // Получаем все опубликованные филиалы
    $filials = get_posts(array(
        'post_type' => 'filial',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="employee_position">Должность</label>
            </th>
            <td>
                <input type="text" 
                       id="employee_position" 
                       name="employee_position" 
                       value="<?php echo esc_attr($position); ?>" 
                       placeholder="Врач" 
                       style="width: 100%; max-width: 400px;" />
                <p class="description">Укажите должность сотрудника</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="employee_phone">Телефон</label>
            </th>
            <td>
                <input type="tel" 
                       id="employee_phone" 
                       name="employee_phone" 
                       value="<?php echo esc_attr($phone); ?>" 
                       placeholder="+7 (999) 123-45-67" 
                       style="width: 100%; max-width: 400px;" />
                <p class="description">Контактный телефон сотрудника</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="employee_appointment_link">Ссылка на запись</label>
            </th>
            <td>
                <input type="url" 
                       id="employee_appointment_link" 
                       name="employee_appointment_link" 
                       value="<?php echo esc_url($appointment_link); ?>" 
                       placeholder="https://example.com/appointment" 
                       style="width: 100%; max-width: 400px;" />
                <p class="description">Ссылка для записи к сотруднику</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="employee_reviews_link">Ссылка на отзывы</label>
            </th>
            <td>
                <input type="url" 
                       id="employee_reviews_link" 
                       name="employee_reviews_link" 
                       value="<?php echo esc_url($reviews_link); ?>" 
                       placeholder="https://example.com/reviews" 
                       style="width: 100%; max-width: 400px;" />
                <p class="description">Ссылка на страницу с отзывами о сотруднике</p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label for="employee_filial_id">Филиал</label>
            </th>
            <td>
                <select id="employee_filial_id" name="employee_filial_id" style="width: 100%; max-width: 400px;">
                    <option value="">— Выберите филиал —</option>
                    <?php if (!empty($filials)) : ?>
                        <?php foreach ($filials as $filial) : ?>
                            <option value="<?php echo esc_attr($filial->ID); ?>" <?php selected($filial_id, $filial->ID); ?>>
                                <?php echo esc_html($filial->post_title); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="" disabled>Нет доступных филиалов</option>
                    <?php endif; ?>
                </select>
                <p class="description">Выберите филиал, к которому привязан сотрудник</p>
                
                <?php if (!empty($filial_id)) : 
                    $filial = get_post($filial_id);
                    if ($filial) : ?>
                        <p style="margin-top: 5px;">
                            <a href="<?php echo get_edit_post_link($filial_id); ?>" target="_blank">
                                Редактировать филиал: <?php echo esc_html($filial->post_title); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    
    <?php
}

// 3. Сохранение данных
add_action('save_post', 'save_employee_info');
function save_employee_info($post_id) {
    // Проверка nonce
    if (!isset($_POST['employee_info_nonce_field'])) {
        return;
    }
    
    if (!wp_verify_nonce($_POST['employee_info_nonce_field'], 'employee_info_nonce')) {
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
    if (get_post_type($post_id) !== 'employee') {
        return;
    }
    
    // Массив полей для сохранения
    $fields = array(
        'employee_position' => '_employee_position',
        'employee_phone' => '_employee_phone',
        'employee_appointment_link' => '_employee_appointment_link',
        'employee_reviews_link' => '_employee_reviews_link',
        'employee_filial_id' => '_employee_filial_id'
    );
    
    foreach ($fields as $field_name => $meta_key) {
        if (isset($_POST[$field_name])) {
            if ($field_name === 'employee_filial_id') {
                // Для ID филиала - числовое значение
                $value = intval($_POST[$field_name]);
            } elseif (strpos($field_name, 'link') !== false || strpos($field_name, 'url') !== false) {
                // Для URL-полей
                $value = esc_url_raw($_POST[$field_name]);
            } else {
                // Для текстовых полей
                $value = sanitize_text_field($_POST[$field_name]);
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
add_filter('manage_employee_posts_columns', 'add_employee_columns');
function add_employee_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['employee_position'] = 'Должность';
            $new_columns['employee_phone'] = 'Телефон';
            $new_columns['employee_filial'] = 'Филиал';
        }
    }
    
    return $new_columns;
}

add_action('manage_employee_posts_custom_column', 'display_employee_columns', 10, 2);
function display_employee_columns($column, $post_id) {
    switch ($column) {
        case 'employee_position':
            $position = get_post_meta($post_id, '_employee_position', true);
            echo !empty($position) ? esc_html($position) : '—';
            break;
            
        case 'employee_phone':
            $phone = get_post_meta($post_id, '_employee_phone', true);
            if (!empty($phone)) {
                echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'employee_filial':
            $filial_id = get_post_meta($post_id, '_employee_filial_id', true);
            if (!empty($filial_id)) {
                $filial = get_post($filial_id);
                if ($filial) {
                    echo '<a href="' . get_edit_post_link($filial_id) . '">' . esc_html($filial->post_title) . '</a>';
                } else {
                    echo 'Филиал удален';
                }
            } else {
                echo '—';
            }
            break;
    }
}

// 5. Фильтр по филиалам в админке
add_action('restrict_manage_posts', 'employee_filial_filter');
function employee_filial_filter($post_type) {
    if ($post_type !== 'employee') {
        return;
    }
    
    $selected = isset($_GET['employee_filial_filter']) ? $_GET['employee_filial_filter'] : '';
    
    // Получаем все филиалы
    $filials = get_posts(array(
        'post_type' => 'filial',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    ?>
    <select name="employee_filial_filter">
        <option value="">Все филиалы</option>
        <option value="empty" <?php selected($selected, 'empty'); ?>>Без филиала</option>
        <?php foreach ($filials as $filial) : ?>
            <option value="<?php echo esc_attr($filial->ID); ?>" <?php selected($selected, $filial->ID); ?>>
                <?php echo esc_html($filial->post_title); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
}

add_filter('parse_query', 'employee_filial_filter_query');
function employee_filial_filter_query($query) {
    global $pagenow;
    
    if ($pagenow !== 'edit.php' || !isset($query->query_vars['post_type']) || $query->query_vars['post_type'] !== 'employee') {
        return $query;
    }
    
    if (!isset($_GET['employee_filial_filter']) || empty($_GET['employee_filial_filter'])) {
        return $query;
    }
    
    $filter_value = $_GET['employee_filial_filter'];
    
    if ($filter_value === 'empty') {
        $query->query_vars['meta_query'] = array(
            array(
                'key' => '_employee_filial_id',
                'compare' => 'NOT EXISTS'
            )
        );
    } else {
        $query->query_vars['meta_query'] = array(
            array(
                'key' => '_employee_filial_id',
                'value' => intval($filter_value),
                'type' => 'NUMERIC'
            )
        );
    }
    
    return $query;
}

// 6. Функции-помощники для вывода на фронтенде
function get_employee_position($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_employee_position', true);
}

function get_employee_phone($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_employee_phone', true);
}

function get_employee_appointment_link($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_employee_appointment_link', true);
}

function get_employee_reviews_link($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_employee_reviews_link', true);
}

function get_employee_filial_id($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    return get_post_meta($post_id, '_employee_filial_id', true);
}

function get_employee_filial_object($post_id = null) {
    $filial_id = get_employee_filial_id($post_id);
    if (!empty($filial_id)) {
        return get_post($filial_id);
    }
    return false;
}

function get_employee_filial_title($post_id = null) {
    $filial = get_employee_filial_object($post_id);
    return $filial ? $filial->post_title : '';
}

// 7. Функция для вывода полной информации о сотруднике
function display_employee_info($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $position = get_employee_position($post_id);
    $phone = get_employee_phone($post_id);
    $appointment_link = get_employee_appointment_link($post_id);
    $reviews_link = get_employee_reviews_link($post_id);
    $filial_title = get_employee_filial_title($post_id);
    
    $output = '<div class="employee-info">';
    
    if (!empty($position)) {
        $output .= '<div class="employee-position">';
        $output .= '<span class="label">Должность:</span> ';
        $output .= '<span class="value">' . esc_html($position) . '</span>';
        $output .= '</div>';
    }
    
    if (!empty($phone)) {
        $output .= '<div class="employee-phone">';
        $output .= '<span class="label">Телефон:</span> ';
        $output .= '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
        $output .= '</div>';
    }
    
    if (!empty($filial_title)) {
        $output .= '<div class="employee-filial">';
        $output .= '<span class="label">Филиал:</span> ';
        $output .= '<span class="value">' . esc_html($filial_title) . '</span>';
        $output .= '</div>';
    }
    
    if (!empty($appointment_link)) {
        $output .= '<div class="employee-appointment">';
        $output .= '<a href="' . esc_url($appointment_link) . '" class="appointment-btn">Записаться</a>';
        $output .= '</div>';
    }
    
    if (!empty($reviews_link)) {
        $output .= '<div class="employee-reviews">';
        $output .= '<a href="' . esc_url($reviews_link) . '" target="_blank" rel="noopener noreferrer">Отзывы о сотруднике</a>';
        $output .= '</div>';
    }
    
    $output .= '</div>';
    
    return $output;
}
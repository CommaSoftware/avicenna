<?php
/**
 * Мета-поля для произвольного типа записи "service":
 *  - Филиал (ID записи типа "filial")
 *  - Цена (текст)
 *  - Ссылка для кнопки "Записаться" (URL)
 */

// 1. Регистрация мета-бокса
add_action('add_meta_boxes', 'service_meta_boxes');
function service_meta_boxes() {
	add_meta_box(
		'service_filial_box',
		'Привязка к филиалу',
		'service_filial_meta_box_callback',
		'service',
		'side',
		'default'
	);

	add_meta_box(
		'service_details_box',
		'Детали услуги',
		'service_details_meta_box_callback',
		'service',
		'normal',
		'default'
	);
}

// 2. Callback для мета-бокса "Филиал"
function service_filial_meta_box_callback($post) {
	wp_nonce_field('service_filial_nonce', 'service_filial_nonce_field');

	$filial_id = get_post_meta($post->ID, '_service_filial_id', true);

	$filials = get_posts(array(
		'post_type'      => 'filial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	));
	?>
	<div class="service-filial-selector">
		<label for="service_filial_id" style="display:block;margin-bottom:8px;">
			Выберите филиал:
		</label>
		<select id="service_filial_id" name="service_filial_id" style="width:100%;">
			<option value="">— Не выбрано —</option>
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

		<?php if (!empty($filial_id)) :
			$filial = get_post($filial_id);
			if ($filial) : ?>
				<p style="margin-top:8px;padding:8px;background:#f0f0f1;border-radius:4px;">
					<strong>Выбранный филиал:</strong>
					<a href="<?php echo esc_url(get_edit_post_link($filial_id)); ?>" target="_blank">
						<?php echo esc_html($filial->post_title); ?>
					</a>
					<br>
					<a href="<?php echo esc_url(get_permalink($filial_id)); ?>" target="_blank" style="font-size:12px;">
						Посмотреть на сайте →
					</a>
				</p>
			<?php endif; ?>
		<?php endif; ?>
	</div>
	<?php
}

// 3. Callback для мета-бокса "Детали услуги" (цена + ссылка)
function service_details_meta_box_callback($post) {
	wp_nonce_field('service_details_nonce', 'service_details_nonce_field');

	$price     = get_post_meta($post->ID, '_service_price', true);
	$book_link = get_post_meta($post->ID, '_service_book_link', true);
	?>
	<div class="service-details-fields">
		<p>
			<label for="service_price" style="display:block;font-weight:600;margin-bottom:4px;">
				Цена
			</label>
			<input
				type="text"
				id="service_price"
				name="service_price"
				value="<?php echo esc_attr($price); ?>"
				placeholder="XXXX ₽"
				style="width:100%;"
			>
			<span class="description">Можно указать текст: «от 1000 ₽», «бесплатно» и т.п.</span>
		</p>

		<p>
			<label for="service_book_link" style="display:block;font-weight:600;margin-bottom:4px;">
				Ссылка для кнопки «Записаться»
			</label>
			<input
				type="url"
				id="service_book_link"
				name="service_book_link"
				value="<?php echo esc_attr($book_link); ?>"
				placeholder="https://example.com/zapis"
				style="width:100%;"
			>
			<span class="description">Полный URL, куда ведёт кнопка записи.</span>
		</p>
	</div>
	<?php
}

// 4. Сохранение всех мета-полей
add_action('save_post', 'save_service_meta');
function save_service_meta($post_id) {
	// Автосохранение
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Тип записи
	if (get_post_type($post_id) !== 'service') {
		return;
	}

	// Права
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	// --- Филиал ---
	if (isset($_POST['service_filial_nonce_field']) &&
		wp_verify_nonce($_POST['service_filial_nonce_field'], 'service_filial_nonce')) {

		if (isset($_POST['service_filial_id']) && $_POST['service_filial_id'] !== '') {
			$filial_id = intval($_POST['service_filial_id']);
			$filial    = get_post($filial_id);

			if ($filial && $filial->post_type === 'filial') {
				update_post_meta($post_id, '_service_filial_id', $filial_id);
			} else {
				delete_post_meta($post_id, '_service_filial_id');
			}
		} else {
			delete_post_meta($post_id, '_service_filial_id');
		}
	}

	// --- Цена ---
	if (isset($_POST['service_details_nonce_field']) &&
		wp_verify_nonce($_POST['service_details_nonce_field'], 'service_details_nonce')) {

		// Цена
		if (isset($_POST['service_price'])) {
			$price = sanitize_text_field(wp_unslash($_POST['service_price']));
			if ($price !== '') {
				update_post_meta($post_id, '_service_price', $price);
			} else {
				delete_post_meta($post_id, '_service_price');
			}
		}

		// Ссылка для кнопки
		if (isset($_POST['service_book_link'])) {
			$book_link = esc_url_raw(wp_unslash($_POST['service_book_link']));
			if ($book_link !== '') {
				update_post_meta($post_id, '_service_book_link', $book_link);
			} else {
				delete_post_meta($post_id, '_service_book_link');
			}
		}
	}
}

// 5. Колонки в админке для "service"
add_filter('manage_service_posts_columns', 'add_service_columns');
function add_service_columns($columns) {
	$new_columns = array();

	foreach ($columns as $key => $value) {
		$new_columns[$key] = $value;
		if ($key === 'title') {
			$new_columns['service_filial'] = 'Филиал';
			$new_columns['service_price']  = 'Цена';
			$new_columns['service_book']   = 'Записаться';
		}
	}

	return $new_columns;
}

add_action('manage_service_posts_custom_column', 'display_service_columns', 10, 2);
function display_service_columns($column, $post_id) {
	if ($column === 'service_filial') {
		$filial_id = get_post_meta($post_id, '_service_filial_id', true);
		if (!empty($filial_id)) {
			$filial = get_post($filial_id);
			if ($filial) {
				echo '<a href="' . esc_url(get_edit_post_link($filial_id)) . '">' . esc_html($filial->post_title) . '</a>';
			} else {
				echo '<span style="color:#999;">Филиал удалён</span>';
			}
		} else {
			echo '<span style="color:#ccc;">—</span>';
		}
	}

	if ($column === 'service_price') {
		$price = get_post_meta($post_id, '_service_price', true);
		echo $price !== '' ? esc_html($price) : '<span style="color:#ccc;">—</span>';
	}

	if ($column === 'service_book') {
		$link = get_post_meta($post_id, '_service_book_link', true);
		if (!empty($link)) {
			echo '<a href="' . esc_url($link) . '" target="_blank" rel="noopener">Ссылка</a>';
		} else {
			echo '<span style="color:#ccc;">—</span>';
		}
	}
}

// 6. Фильтр по филиалам в админке для "service"
add_action('restrict_manage_posts', 'service_filial_filter');
function service_filial_filter($post_type) {
	if ($post_type !== 'service') {
		return;
	}

	$selected = isset($_GET['service_filial_filter']) ? $_GET['service_filial_filter'] : '';

	$filials = get_posts(array(
		'post_type'      => 'filial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	));
	?>
	<select name="service_filial_filter">
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

add_filter('parse_query', 'service_filial_filter_query');
function service_filial_filter_query($query) {
	global $pagenow;

	if ($pagenow !== 'edit.php' || !isset($query->query_vars['post_type']) || $query->query_vars['post_type'] !== 'service') {
		return $query;
	}

	if (!isset($_GET['service_filial_filter']) || $_GET['service_filial_filter'] === '') {
		return $query;
	}

	$filter_value = $_GET['service_filial_filter'];

	if ($filter_value === 'empty') {
		$query->query_vars['meta_query'] = array(
			array(
				'key'     => '_service_filial_id',
				'compare' => 'NOT EXISTS',
			),
		);
	} else {
		$query->query_vars['meta_query'] = array(
			array(
				'key'   => '_service_filial_id',
				'value' => intval($filter_value),
				'type'  => 'NUMERIC',
			),
		);
	}

	return $query;
}

// 7. Быстрое редактирование (Quick Edit)
add_action('quick_edit_custom_box', 'service_quick_edit_box', 10, 2);
function service_quick_edit_box($column_name, $post_type) {
	if ($post_type !== 'service') {
		return;
	}

	// Филиал
	if ($column_name === 'service_filial') {
		$filials = get_posts(array(
			'post_type'      => 'filial',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		));
		?>
		<fieldset class="inline-edit-col-left">
			<div class="inline-edit-col">
				<label class="inline-edit-group">
					<span class="title">Филиал</span>
					<select name="service_filial_id">
						<option value="">— Не выбрано —</option>
						<?php foreach ($filials as $filial) : ?>
							<option value="<?php echo esc_attr($filial->ID); ?>">
								<?php echo esc_html($filial->post_title); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</label>
			</div>
		</fieldset>
		<?php
	}

	// Цена
	if ($column_name === 'service_price') {
		?>
		<fieldset class="inline-edit-col-left">
			<div class="inline-edit-col">
				<label class="inline-edit-group">
					<span class="title">Цена</span>
					<input type="text" name="service_price" value="">
				</label>
			</div>
		</fieldset>
		<?php
	}

	// Ссылка для кнопки
	if ($column_name === 'service_book') {
		?>
		<fieldset class="inline-edit-col-left">
			<div class="inline-edit-col">
				<label class="inline-edit-group">
					<span class="title">Записаться (URL)</span>
					<input type="url" name="service_book_link" value="">
				</label>
			</div>
		</fieldset>
		<?php
	}
}

// Сохранение из Quick Edit
add_action('save_post', 'save_service_quick_edit');
function save_service_quick_edit($post_id) {
	if (!isset($_POST['_inline_edit']) || !wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (get_post_type($post_id) !== 'service') {
		return;
	}

	// Филиал
	if (isset($_POST['service_filial_id'])) {
		$filial_id = intval($_POST['service_filial_id']);
		if (!empty($filial_id)) {
			$filial = get_post($filial_id);
			if ($filial && $filial->post_type === 'filial') {
				update_post_meta($post_id, '_service_filial_id', $filial_id);
			} else {
				delete_post_meta($post_id, '_service_filial_id');
			}
		} else {
			delete_post_meta($post_id, '_service_filial_id');
		}
	}

	// Цена
	if (isset($_POST['service_price'])) {
		$price = sanitize_text_field(wp_unslash($_POST['service_price']));
		if ($price !== '') {
			update_post_meta($post_id, '_service_price', $price);
		} else {
			delete_post_meta($post_id, '_service_price');
		}
	}

	// Ссылка
	if (isset($_POST['service_book_link'])) {
		$book_link = esc_url_raw(wp_unslash($_POST['service_book_link']));
		if ($book_link !== '') {
			update_post_meta($post_id, '_service_book_link', $book_link);
		} else {
			delete_post_meta($post_id, '_service_book_link');
		}
	}
}

// 8. Функции-помощники для вывода на фронтенде
function get_service_filial_id($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return get_post_meta($post_id, '_service_filial_id', true);
}

function get_service_filial_object($post_id = null) {
	$filial_id = get_service_filial_id($post_id);
	if (!empty($filial_id)) {
		return get_post($filial_id);
	}
	return false;
}

function get_service_filial_title($post_id = null) {
	$filial = get_service_filial_object($post_id);
	return $filial ? $filial->post_title : '';
}

function get_service_filial_link($post_id = null) {
	$filial = get_service_filial_object($post_id);
	return $filial ? get_permalink($filial->ID) : '';
}

function get_service_price($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return get_post_meta($post_id, '_service_price', true);
}

function get_service_book_link($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return get_post_meta($post_id, '_service_book_link', true);
}
<?php
/**
 * Мета-поля для произвольного типа записи "slides":
 *  - Филиал (ID записи типа "filial")
 *  - Ссылка для кнопки "Подробнее" (URL, относительная или якорная)
 *  - Ссылка для кнопки "Записаться" (URL, относительная или якорная)
 */

// 1. Регистрация мета-боксов
add_action('add_meta_boxes', 'slides_meta_boxes');
function slides_meta_boxes() {
	add_meta_box(
		'slides_filial_box',
		'Привязка к филиалу',
		'slides_filial_meta_box_callback',
		'slides',
		'side',
		'default'
	);

	add_meta_box(
		'slides_links_box',
		'Ссылки для кнопок',
		'slides_links_meta_box_callback',
		'slides',
		'normal',
		'default'
	);
}

// 2. Callback для мета-бокса "Филиал"
function slides_filial_meta_box_callback($post) {
	wp_nonce_field('slides_filial_nonce', 'slides_filial_nonce_field');

	$filial_id = get_post_meta($post->ID, '_slides_filial_id', true);

	$filials = get_posts(array(
		'post_type'      => 'filial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	));
	?>
	<div class="slides-filial-selector">
		<label for="slides_filial_id" style="display:block;margin-bottom:8px;">
			Выберите филиал:
		</label>
		<select id="slides_filial_id" name="slides_filial_id" style="width:100%;">
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

// 3. Callback для мета-бокса "Ссылки для кнопок"
function slides_links_meta_box_callback($post) {
	wp_nonce_field('slides_links_nonce', 'slides_links_nonce_field');

	$more_link = get_post_meta($post->ID, '_slides_more_link', true);
	$book_link = get_post_meta($post->ID, '_slides_book_link', true);
	?>
	<div class="slides-links-fields">
		<p>
			<label for="slides_more_link" style="display:block;font-weight:600;margin-bottom:4px;">
				Ссылка для кнопки «Подробнее»
			</label>
			<input
				type="text"
				id="slides_more_link"
				name="slides_more_link"
				value="<?php echo esc_attr($more_link); ?>"
				placeholder="https://"
				style="width:100%;"
			>
			<span class="description">
				Введите полный URL <code>https://...</code>,
				относительный путь (<code>/service</code>), или якорные ссылки <code>#services_check-up</code>).
			</span>
		</p>

		<p>
			<label for="slides_book_link" style="display:block;font-weight:600;margin-bottom:4px;">
				Ссылка для кнопки «Записаться»
			</label>
			<input
				type="text"
				id="slides_book_link"
				name="slides_book_link"
				value="<?php echo esc_attr($book_link); ?>"
				placeholder="https://"
				style="width:100%;"
			>
			<span class="description">
				Введите полный URL <code>https://...</code> до страницы записи
			</span>
		</p>
	</div>
	<?php
}

/**
 * Универсальная очистка ссылки:
 * - разрешает полные URL (http, https, mailto, tel, и т.п. через esc_url_raw)
 * - разрешает относительные пути (/path/, path/, ../path)
 * - разрешает якоря (#anchor)
 * - разрешает путь с якорем (/#anchor, /path/#anchor)
 *
 * @param string $value
 * @return string
 */
function slides_sanitize_link($value) {
	$value = trim(wp_unslash($value));

	if ($value === '') {
		return '';
	}

	// Если это якорь вида "#readmore" или "path/#readmore" или "/#readmore"
	if (preg_match('~^[a-zA-Z0-9_\-./?=&%#]*#[\w\-.:]+$~u', $value) && strpos($value, '://') === false) {
		// Очищаем на всякий случай от опасных символов, но оставляем #, /, ?, =, &, %, ., -, _
		return preg_replace('~[^a-zA-Z0-9_\-./?=&%#:\p{L}]~u', '', $value);
	}

	// Относительный путь: /path/, path/, ../path/
	if (preg_match('~^(\.{0,2}/|/)?[a-zA-Z0-9_\-./?=&%\p{L}]+$~u', $value) && strpos($value, '://') === false) {
		return preg_replace('~[^a-zA-Z0-9_\-./?=&%:\p{L}]~u', '', $value);
	}

	// Во всех остальных случаях — как полноценный URL
	return esc_url_raw($value);
}

// 4. Сохранение всех мета-полей
add_action('save_post', 'save_slides_meta');
function save_slides_meta($post_id) {
	// Автосохранение
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Тип записи
	if (get_post_type($post_id) !== 'slides') {
		return;
	}

	// Права
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	// --- Филиал ---
	if (isset($_POST['slides_filial_nonce_field']) &&
		wp_verify_nonce($_POST['slides_filial_nonce_field'], 'slides_filial_nonce')) {

		if (isset($_POST['slides_filial_id']) && $_POST['slides_filial_id'] !== '') {
			$filial_id = intval($_POST['slides_filial_id']);
			$filial    = get_post($filial_id);

			if ($filial && $filial->post_type === 'filial') {
				update_post_meta($post_id, '_slides_filial_id', $filial_id);
			} else {
				delete_post_meta($post_id, '_slides_filial_id');
			}
		} else {
			delete_post_meta($post_id, '_slides_filial_id');
		}
	}

	// --- Ссылки ---
	if (isset($_POST['slides_links_nonce_field']) &&
		wp_verify_nonce($_POST['slides_links_nonce_field'], 'slides_links_nonce')) {

		// Ссылка "Подробнее"
		if (isset($_POST['slides_more_link'])) {
			$more_link = slides_sanitize_link($_POST['slides_more_link']);
			if ($more_link !== '') {
				update_post_meta($post_id, '_slides_more_link', $more_link);
			} else {
				delete_post_meta($post_id, '_slides_more_link');
			}
		}

		// Ссылка "Записаться"
		if (isset($_POST['slides_book_link'])) {
			$book_link = slides_sanitize_link($_POST['slides_book_link']);
			if ($book_link !== '') {
				update_post_meta($post_id, '_slides_book_link', $book_link);
			} else {
				delete_post_meta($post_id, '_slides_book_link');
			}
		}
	}
}

// 5. Колонки в админке для "slides"
add_filter('manage_slides_posts_columns', 'add_slides_columns');
function add_slides_columns($columns) {
	$new_columns = array();

	foreach ($columns as $key => $value) {
		$new_columns[$key] = $value;
		if ($key === 'title') {
			$new_columns['slides_filial'] = 'Филиал';
			$new_columns['slides_more']   = 'Подробнее';
			$new_columns['slides_book']   = 'Записаться';
		}
	}

	return $new_columns;
}

add_action('manage_slides_posts_custom_column', 'display_slides_columns', 10, 2);
function display_slides_columns($column, $post_id) {
	if ($column === 'slides_filial') {
		$filial_id = get_post_meta($post_id, '_slides_filial_id', true);
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

	if ($column === 'slides_more') {
		$link = get_post_meta($post_id, '_slides_more_link', true);
		if (!empty($link)) {
			echo '<a href="' . esc_url($link) . '" target="_blank" rel="noopener">Ссылка</a>';
		} else {
			echo '<span style="color:#ccc;">—</span>';
		}
	}

	if ($column === 'slides_book') {
		$link = get_post_meta($post_id, '_slides_book_link', true);
		if (!empty($link)) {
			echo '<a href="' . esc_url($link) . '" target="_blank" rel="noopener">Ссылка</a>';
		} else {
			echo '<span style="color:#ccc;">—</span>';
		}
	}
}

// 6. Фильтр по филиалам в админке для "slides"
add_action('restrict_manage_posts', 'slides_filial_filter');
function slides_filial_filter($post_type) {
	if ($post_type !== 'slides') {
		return;
	}

	$selected = isset($_GET['slides_filial_filter']) ? $_GET['slides_filial_filter'] : '';

	$filials = get_posts(array(
		'post_type'      => 'filial',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	));
	?>
	<select name="slides_filial_filter">
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

add_filter('parse_query', 'slides_filial_filter_query');
function slides_filial_filter_query($query) {
	global $pagenow;

	if ($pagenow !== 'edit.php' || !isset($query->query_vars['post_type']) || $query->query_vars['post_type'] !== 'slides') {
		return $query;
	}

	if (!isset($_GET['slides_filial_filter']) || $_GET['slides_filial_filter'] === '') {
		return $query;
	}

	$filter_value = $_GET['slides_filial_filter'];

	if ($filter_value === 'empty') {
		$query->query_vars['meta_query'] = array(
			array(
				'key'     => '_slides_filial_id',
				'compare' => 'NOT EXISTS',
			),
		);
	} else {
		$query->query_vars['meta_query'] = array(
			array(
				'key'   => '_slides_filial_id',
				'value' => intval($filter_value),
				'type'  => 'NUMERIC',
			),
		);
	}

	return $query;
}

// 7. Быстрое редактирование (Quick Edit)
add_action('quick_edit_custom_box', 'slides_quick_edit_box', 10, 2);
function slides_quick_edit_box($column_name, $post_type) {
	if ($post_type !== 'slides') {
		return;
	}

	// Филиал
	if ($column_name === 'slides_filial') {
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
					<select name="slides_filial_id">
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

	// Ссылка "Подробнее"
	if ($column_name === 'slides_more') {
		?>
		<fieldset class="inline-edit-col-left">
			<div class="inline-edit-col">
				<label class="inline-edit-group">
					<span class="title">Подробнее (URL/путь/якорь)</span>
					<input type="text" name="slides_more_link" value="" placeholder="/#readmore">
				</label>
			</div>
		</fieldset>
		<?php
	}

	// Ссылка "Записаться"
	if ($column_name === 'slides_book') {
		?>
		<fieldset class="inline-edit-col-left">
			<div class="inline-edit-col">
				<label class="inline-edit-group">
					<span class="title">Записаться (URL/путь/якорь)</span>
					<input type="text" name="slides_book_link" value="" placeholder="/#zapis">
				</label>
			</div>
		</fieldset>
		<?php
	}
}

// Сохранение из Quick Edit
add_action('save_post', 'save_slides_quick_edit');
function save_slides_quick_edit($post_id) {
	if (!isset($_POST['_inline_edit']) || !wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
		return;
	}

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	if (!current_user_can('edit_post', $post_id)) {
		return;
	}

	if (get_post_type($post_id) !== 'slides') {
		return;
	}

	// Филиал
	if (isset($_POST['slides_filial_id'])) {
		$filial_id = intval($_POST['slides_filial_id']);
		if (!empty($filial_id)) {
			$filial = get_post($filial_id);
			if ($filial && $filial->post_type === 'filial') {
				update_post_meta($post_id, '_slides_filial_id', $filial_id);
			} else {
				delete_post_meta($post_id, '_slides_filial_id');
			}
		} else {
			delete_post_meta($post_id, '_slides_filial_id');
		}
	}

	// Ссылка "Подробнее"
	if (isset($_POST['slides_more_link'])) {
		$more_link = slides_sanitize_link($_POST['slides_more_link']);
		if ($more_link !== '') {
			update_post_meta($post_id, '_slides_more_link', $more_link);
		} else {
			delete_post_meta($post_id, '_slides_more_link');
		}
	}

	// Ссылка "Записаться"
	if (isset($_POST['slides_book_link'])) {
		$book_link = slides_sanitize_link($_POST['slides_book_link']);
		if ($book_link !== '') {
			update_post_meta($post_id, '_slides_book_link', $book_link);
		} else {
			delete_post_meta($post_id, '_slides_book_link');
		}
	}
}

// 8. Функции-помощники для вывода на фронтенде
function get_slides_filial_id($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return get_post_meta($post_id, '_slides_filial_id', true);
}

function get_slides_filial_object($post_id = null) {
	$filial_id = get_slides_filial_id($post_id);
	if (!empty($filial_id)) {
		return get_post($filial_id);
	}
	return false;
}

function get_slides_filial_title($post_id = null) {
	$filial = get_slides_filial_object($post_id);
	return $filial ? $filial->post_title : '';
}

function get_slides_filial_link($post_id = null) {
	$filial = get_slides_filial_object($post_id);
	return $filial ? get_permalink($filial->ID) : '';
}

function get_slides_more_link($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return get_post_meta($post_id, '_slides_more_link', true);
}

function get_slides_book_link($post_id = null) {
	if (!$post_id) {
		$post_id = get_the_ID();
	}
	return get_post_meta($post_id, '_slides_book_link', true);
}
<?php
/**
 * Добавление поля "Филиал" для стандартных записей (posts)
 */

// 1. Регистрация мета-бокса для стандартных записей
add_action('add_meta_boxes', 'post_filial_meta_box');
function post_filial_meta_box() {
		add_meta_box(
				'post_filial_box',
				'Привязка к филиалу',
				'post_filial_meta_box_callback',
				'post', // Для стандартных записей
				'side', // В боковой колонке
				'default'
		);
}

// 2. Callback-функция для вывода поля
function post_filial_meta_box_callback($post) {
		// Nonce для безопасности
		wp_nonce_field('post_filial_nonce', 'post_filial_nonce_field');
		
		// Получаем сохраненное значение
		$filial_id = get_post_meta($post->ID, '_post_filial_id', true);
		
		// Получаем все опубликованные филиалы
		$filials = get_posts(array(
				'post_type' => 'filial',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
		));
		?>
		
		<div class="post-filial-selector">
			<label for="post_filial_id" style="display: block; margin-bottom: 8px;">
					Выберите филиал:
			</label>
			<select id="post_filial_id" name="post_filial_id">
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
							<p style="margin-top: 8px; padding: 8px; background: #f0f0f1; border-radius: 4px;">
									<strong>Выбранный филиал:</strong> 
									<a href="<?php echo get_edit_post_link($filial_id); ?>" target="_blank">
											<?php echo esc_html($filial->post_title); ?>
									</a>
									<br>
									<a href="<?php echo get_permalink($filial_id); ?>" target="_blank" style="font-size: 12px;">
											Посмотреть на сайте →
									</a>
							</p>
					<?php endif; ?>
			<?php endif; ?>
		</div>
		
		<?php
}

// 3. Сохранение данных
add_action('save_post', 'save_post_filial');
function save_post_filial($post_id) {
		// Проверка nonce
		if (!isset($_POST['post_filial_nonce_field'])) {
				return;
		}
		
		if (!wp_verify_nonce($_POST['post_filial_nonce_field'], 'post_filial_nonce')) {
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
		
		// Проверка типа записи (только для стандартных постов)
		if (get_post_type($post_id) !== 'post') {
				return;
		}
		
		// Сохраняем значение
		if (isset($_POST['post_filial_id']) && !empty($_POST['post_filial_id'])) {
				$filial_id = intval($_POST['post_filial_id']);
				
				// Проверяем, существует ли филиал
				$filial = get_post($filial_id);
				if ($filial && $filial->post_type === 'filial') {
						update_post_meta($post_id, '_post_filial_id', $filial_id);
				} else {
						delete_post_meta($post_id, '_post_filial_id');
				}
		} else {
				delete_post_meta($post_id, '_post_filial_id');
		}
}

// 4. Добавление колонки в админке
add_filter('manage_post_posts_columns', 'add_post_filial_column');
function add_post_filial_column($columns) {
		$new_columns = array();
		
		foreach ($columns as $key => $value) {
				$new_columns[$key] = $value;
				if ($key === 'title') {
						$new_columns['post_filial'] = 'Филиал';
				}
		}
		
		return $new_columns;
}

add_action('manage_post_posts_custom_column', 'display_post_filial_column', 10, 2);
function display_post_filial_column($column, $post_id) {
		if ($column === 'post_filial') {
				$filial_id = get_post_meta($post_id, '_post_filial_id', true);
				if (!empty($filial_id)) {
						$filial = get_post($filial_id);
						if ($filial) {
								echo '<a href="' . get_edit_post_link($filial_id) . '">' . esc_html($filial->post_title) . '</a>';
								echo '<br><a href="' . get_permalink($filial_id) . '" target="_blank" style="font-size: 11px; color: #666;">Просмотр</a>';
						} else {
								echo '<span style="color: #999;">Филиал удален</span>';
						}
				} else {
						echo '<span style="color: #ccc;">—</span>';
				}
		}
}

// 5. Фильтр по филиалам в админке для постов
add_action('restrict_manage_posts', 'post_filial_filter');
function post_filial_filter($post_type) {
		if ($post_type !== 'post') {
				return;
		}
		
		$selected = isset($_GET['post_filial_filter']) ? $_GET['post_filial_filter'] : '';
		
		// Получаем все филиалы
		$filials = get_posts(array(
				'post_type' => 'filial',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
		));
		?>
		<select name="post_filial_filter">
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

add_filter('parse_query', 'post_filial_filter_query');
function post_filial_filter_query($query) {
		global $pagenow;
		
		if ($pagenow !== 'edit.php' || !isset($query->query_vars['post_type']) || $query->query_vars['post_type'] !== 'post') {
				return $query;
		}
		
		if (!isset($_GET['post_filial_filter']) || empty($_GET['post_filial_filter'])) {
				return $query;
		}
		
		$filter_value = $_GET['post_filial_filter'];
		
		if ($filter_value === 'empty') {
				$query->query_vars['meta_query'] = array(
						array(
								'key' => '_post_filial_id',
								'compare' => 'NOT EXISTS'
						)
				);
		} else {
				$query->query_vars['meta_query'] = array(
						array(
								'key' => '_post_filial_id',
								'value' => intval($filter_value),
								'type' => 'NUMERIC'
						)
				);
		}
		
		return $query;
}

// 6. Функции-помощники для вывода на фронтенде
function get_post_filial_id($post_id = null) {
		if (!$post_id) {
				$post_id = get_the_ID();
		}
		return get_post_meta($post_id, '_post_filial_id', true);
}

function get_post_filial_object($post_id = null) {
		$filial_id = get_post_filial_id($post_id);
		if (!empty($filial_id)) {
				return get_post($filial_id);
		}
		return false;
}

function get_post_filial_title($post_id = null) {
		$filial = get_post_filial_object($post_id);
		return $filial ? $filial->post_title : '';
}

function get_post_filial_link($post_id = null) {
		$filial = get_post_filial_object($post_id);
		return $filial ? get_permalink($filial->ID) : '';
}

// 7. Быстрое редактирование (Quick Edit)
add_action('quick_edit_custom_box', 'post_filial_quick_edit', 10, 2);
function post_filial_quick_edit($column_name, $post_type) {
		if ($column_name !== 'post_filial' || $post_type !== 'post') {
				return;
		}
		
		// Получаем все филиалы
		$filials = get_posts(array(
				'post_type' => 'filial',
				'post_status' => 'publish',
				'posts_per_page' => -1,
				'orderby' => 'title',
				'order' => 'ASC'
		));
		?>
		<fieldset class="inline-edit-col-left">
				<div class="inline-edit-col">
						<label class="inline-edit-group">
								<span class="title">Филиал</span>
								<select name="post_filial_id">
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

// Сохранение при быстром редактировании
add_action('save_post', 'save_post_filial_quick_edit');
function save_post_filial_quick_edit($post_id) {
		// Проверка на быстрое редактирование
		if (!isset($_POST['_inline_edit']) || !wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) {
				return;
		}
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
		}
		
		if (!current_user_can('edit_post', $post_id)) {
				return;
		}
		
		if (get_post_type($post_id) !== 'post') {
				return;
		}
		
		if (isset($_POST['post_filial_id'])) {
				$filial_id = intval($_POST['post_filial_id']);
				if (!empty($filial_id)) {
						$filial = get_post($filial_id);
						if ($filial && $filial->post_type === 'filial') {
								update_post_meta($post_id, '_post_filial_id', $filial_id);
						} else {
								delete_post_meta($post_id, '_post_filial_id');
						}
				} else {
						delete_post_meta($post_id, '_post_filial_id');
				}
		}
}
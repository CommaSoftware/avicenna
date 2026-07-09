<?php

// Функция получения списка иконок
function custom_get_icons_list() {
	$icons_dir = get_template_directory() . '/assets/images/icons/';
	$icons = [];
	
	if (is_dir($icons_dir)) {
		$files = scandir($icons_dir);
		foreach ($files as $file) {
			if (pathinfo($file, PATHINFO_EXTENSION) === 'svg') {
				$name = pathinfo($file, PATHINFO_FILENAME);
				$icons[$name] = ucfirst(str_replace('-', ' ', $name));
			}
		}
	}
	
	return $icons;
}

function custom_get_icons_options() {
	$icons_list = custom_get_icons_list();
	$icons_options = ['' => '—'];
	
	if (is_array($icons_list) && !empty($icons_list)) {
		$icons_options = array_merge($icons_options, $icons_list);
	}
	
	return $icons_options;
}
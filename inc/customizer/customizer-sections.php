<?php
add_action('customize_register', function($wp_customize) {
	$wp_customize->add_panel('sections_panel', [
		'title'       => __('Настройка блоков', 'mobilelectro'),
		'description' => 'Шапка, подвал и прочее',
		'priority'    => 100,
	]);
});
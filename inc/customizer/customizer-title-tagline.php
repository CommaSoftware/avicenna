<?php
add_action('customize_register', function($wp_customize) {
	$wp_customize->add_setting('title_tagline__head_code',[
			'default' => '',
	]);
	$wp_customize->add_control(
		'title_tagline__head_code',
		array(
			'label' => __('HTML код для вставки в <HEAD>', THEME_PREFIX),
			'description' => __('Будьте внимательны! Встраивайте только код, в безопасности которого уверены!', THEME_PREFIX),
			'section' => 'title_tagline',
			'settings' => 'title_tagline__head_code',
			'type' => 'text',
		)
	);
});
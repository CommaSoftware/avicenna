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
			'type' => 'textarea',
		)
	);

	$wp_customize->add_setting('title_tagline__counter',[
			'default' => '',
	]);
	$wp_customize->add_control(
		'title_tagline__counter',
		array(
			'label' => __('HTML код счётчика посещаемости', THEME_PREFIX),
			'description' => __('Будьте внимательны! Встраивайте только код, в безопасности которого уверены!', THEME_PREFIX),
			'section' => 'title_tagline',
			'settings' => 'title_tagline__counter',
			'type' => 'textarea',
		)
	);

		$wp_customize->add_setting('title_tagline__counter_alert',[
			'default' => Theme_Defaults::TITLE_TAGLINE_COUNTER_ALERT,
	]);
	$wp_customize->add_control(
		'title_tagline__counter_alert',
		array(
			'label' => __('HTML код текста плашки об использовании Cookies', THEME_PREFIX),
			'description' => __('Будьте внимательны! Встраивайте только код, в безопасности которого уверены!', THEME_PREFIX),
			'section' => 'title_tagline',
			'settings' => 'title_tagline__counter_alert',
			'type' => 'textarea',
		)
	);
});
<?php
add_action('customize_register', function($wp_customize) {

	$wp_customize->add_section('header', [
		'title'    => 'Шапка',
		'priority' => 1,
		'panel' => 'sections_panel'
	]);

	$icons_list = custom_get_icons_options();

	// Header Logo
	$wp_customize->add_setting('header__logo', [
		'default'           => Theme_Defaults::HEADER_LOGO,
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage'
	]);
	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header__logo', [
		'label'    => __('Логотип в шапке', THEME_PREFIX),
		'section'  => 'header',
		'settings' => 'header__logo',
		'description' => __('Загрузите логотип сайта', THEME_PREFIX),
	]));

	// Accent Button
	$wp_customize->add_setting('header__button1_icon', [
		'default'           => Theme_Defaults::HEADER_BUTTON1_ICON
	]);

	$wp_customize->add_control('header__button1_icon', [
		'type'    => 'select',
		'section' => 'header',
		'label'   => __('Иконка акцентной кнопки', THEME_PREFIX),
		'choices' => $icons_list,
	]);

	$wp_customize->add_setting('header__button1_name', [
		'default'           => Theme_Defaults::HEADER_BUTTON1_NAME
	]);

	$wp_customize->add_control('header__button1_name', [
		'type'    => 'text',
		'section' => 'header',
		'label'   => __('Текст акцентной кнопки', THEME_PREFIX),
	]);

	$wp_customize->add_setting('header__button1_link', [
		'default'           => Theme_Defaults::HEADER_BUTTON1_LINK
	]);

	$wp_customize->add_control('header__button1_link', [
		'type'    => 'text',
		'section' => 'header',
		'label'   => __('Ссылка акцентной кнопки', THEME_PREFIX),
	]);
});
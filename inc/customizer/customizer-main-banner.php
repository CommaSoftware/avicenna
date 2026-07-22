<?php
add_action('customize_register', function($wp_customize) {

	$wp_customize->add_section('main_banner', [
		'title'    => 'Приветственный баннер',
		'priority' => 3,
		'panel' => 'sections_panel'
	]);

	// Main banner Logo
	$wp_customize->add_setting('main_banner__logo', [
		'default'           => Theme_Defaults::MAIN_BANNER_LOGO,
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage'
	]);
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'main_banner__logo', [
		'label'    => __('Логотип в подвале', THEME_PREFIX),
		'section'  => 'main_banner',
		'settings' => 'main_banner__logo',
		'description' => __('Загрузите логотип сайта', THEME_PREFIX),
	]));
		
	// Main banner Linecse Link
	$wp_customize->add_setting('main_banner__license_link', [
		'default' => Theme_Defaults::MAIN_BANNER_LICENSE_LINK,
	]);
	$wp_customize->add_control('main_banner__license_link', [
		'type'    => 'text',
		'section' => 'main_banner',
		'label'   => __('Ссылка на лицензию клиники', THEME_PREFIX),
	]);

	// Main banner HTML block
	$wp_customize->add_setting('main_banner__html_block', [
		'default' => Theme_Defaults::MAIN_BANNER_HTML_BLOCK,
	]);
	$wp_customize->add_control('main_banner__html_block', [
		'type'        => 'text',
		'section'     => 'main_banner',
		'label'       => __('HTML блок', THEME_PREFIX),
		'description' => __('Будьте внимательны! Встраивайте только код, в безопасности которого уверены!', THEME_PREFIX),
	]);
});
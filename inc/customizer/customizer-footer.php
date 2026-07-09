<?php
add_action('customize_register', function($wp_customize) {

	$wp_customize->add_section('footer', [
		'title'    => 'Подвал',
		'priority' => 3,
		'panel' => 'sections_panel'
	]);

	// Footer Logo
	$wp_customize->add_setting('footer__logo', [
		'default'           => Theme_Defaults::FOOTER_LOGO,
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage'
	]);
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer__logo', [
		'label'    => __('Логотип в подвале', THEME_PREFIX),
		'section'  => 'footer',
		'settings' => 'footer__logo',
		'description' => __('Загрузите логотип сайта', THEME_PREFIX),
	]));
		
	// Footer copyright
	$wp_customize->add_setting('footer__copyright_name', [
		'default' => Theme_Defaults::FOOTER_COPYRIGHT_NAME,
	]);
	$wp_customize->add_control('footer__copyright_name', [
		'type'    => 'text',
		'section' => 'footer',
		'label'   => __('Копирайт', THEME_PREFIX),
		'description' => __('Введите только название, текущий год определяется автоматически', THEME_PREFIX),
	]);

	// Footer Links
	$wp_customize->add_setting('footer__privacy_link', [
		'default' => Theme_Defaults::FOOTER_PRIVACY_LINK,
	]);
	$wp_customize->add_control('footer__privacy_link', [
		'type'    => 'text',
		'section' => 'footer',
		'label'   => __('Ссылка на пользовательское соглашение', THEME_PREFIX),
		'description'   => __('Ссылка на страницу пользовательского соглашения и политики конфиденциальности', THEME_PREFIX),
	]);

	$wp_customize->add_setting('footer__offer_name', [
		'default' => Theme_Defaults::FOOTER_OFFER_NAME,
	]);
	$wp_customize->add_control('footer__offer_name', [
		'type'    => 'text',
		'section' => 'footer',
		'label'   => __('Информация об оферте', THEME_PREFIX),
	]);

	$wp_customize->add_setting('footer__offer_link', [
		'default' => Theme_Defaults::FOOTER_OFFER_LINK,
	]);
	$wp_customize->add_control('footer__offer_link', [
		'type'    => 'text',
		'section' => 'footer',
		'label'   => __('Ссылка на ннформацию об оферте', THEME_PREFIX),
	]);

	$wp_customize->add_setting('footer__licenses', [
		'default' => Theme_Defaults::FOOTER_LICENSES_LINK,
	]);
	$wp_customize->add_control('footer__licenses', [
		'type'    => 'text',
		'section' => 'footer',
		'label'   => __('Ссылка на лицензии', THEME_PREFIX),
	]);
});
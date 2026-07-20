<?php
add_action('customize_register', function($wp_customize) {

	$wp_customize->add_section('blog_view', [
		'title'    => 'Предпросмотр «Публикаций»',
		'description' => 'Выводит последние опубликованные материалы типа «Запись», поддерживает закреплённые публикации',
		'priority' => 40,
		'panel' => 'sections_panel'
	]);

	// Show block
	$wp_customize->add_setting( 'blog_view__show_on_front', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::BLOG_VIEW_SHOW_ON_FRONT,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'blog_view__show_on_front', array(
		'label'       => __( 'Показывать блок на главной странице', THEME_PREFIX ),
		'section'     => 'blog_view',
		'type'        => 'checkbox',
	) );

	// Heading
	$wp_customize->add_setting('blog_view__heading', [
		'default'           => Theme_Defaults::BLOG_VIEW_HEADING
	]);

	$wp_customize->add_control('blog_view__heading', [
		'type'    => 'text',
		'section' => 'blog_view',
		'label'   => __('Заголовок', THEME_PREFIX),
	]);

	// Description
	$wp_customize->add_setting('blog_view__description', [
		'default'           => Theme_Defaults::BLOG_VIEW_DESCRIPTION
	]);

	$wp_customize->add_control('blog_view__description', [
		'type'    => 'text',
		'section' => 'blog_view',
		'label'   => __('Описание', THEME_PREFIX),
	]);
});
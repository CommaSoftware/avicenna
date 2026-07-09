<?php
add_action('customize_register', function($wp_customize) {

	$wp_customize->add_section('article_sharing', [
		'title'    => 'Статья «Кнопки Поделиться»',
		'priority' => 52,
		'panel' => 'sections_panel'
	]);

	// Show Chopy Link Button
	$wp_customize->add_setting( 'article_sharing__show_copy_link', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::ARTICLE_SHARING_SHOW_LINK,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'article_sharing__show_copy_link', array(
		'label'       => __( 'Включить «Скопировать ссылку»', THEME_PREFIX ),
		'section'     => 'article_sharing',
		'type'        => 'checkbox',
	) );

	
	// Show Telegram Button
	$wp_customize->add_setting( 'article_sharing__show_tg', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::ARTICLE_SHARING_SHOW_TG,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'article_sharing__show_tg', array(
		'label'       => __( 'Включить «Поделиться в Telegram»', THEME_PREFIX ),
		'section'     => 'article_sharing',
		'type'        => 'checkbox',
	) );

	
	// Show VK Button
	$wp_customize->add_setting( 'article_sharing__show_vk', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::ARTICLE_SHARING_SHOW_VK,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'article_sharing__show_vk', array(
		'label'       => __( 'Включить «Поделиться в VK»', THEME_PREFIX ),
		'section'     => 'article_sharing',
		'type'        => 'checkbox',
	) );

});
<?php
add_action('customize_register', function($wp_customize) {
	
	$wp_customize->add_section('blog_sidebar', [
		'title'    => 'Сайдбар об Авторе публикаций',
		'priority' => 51,
		'panel' => 'sections_panel'
	]);
		
	$icons_list = custom_get_icons_options();
		
	// Show sidebar in Blog
	$wp_customize->add_setting( 'blog_sidebar__show_in_blog', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::BLOG_SIDEBAR_SHOW_IN_BLOG,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'blog_sidebar__show_in_blog', array(
		'label'       => __( 'Показывать на странице блога', THEME_PREFIX ),
		'section'     => 'blog_sidebar',
		'type'        => 'checkbox',
	) );

	// Show Sidebar in Post
	$wp_customize->add_setting( 'blog_sidebar__show_in_post', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::BLOG_SIDEBAR_SHOW_IN_POST,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'blog_sidebar__show_in_post', array(
		'label'       => __( 'Показывать на странице поста', THEME_PREFIX ),
		'section'     => 'blog_sidebar',
		'type'        => 'checkbox',
	) );

	// Description
	$wp_customize->add_setting('blog_sidebar__description', [
		'default' => Theme_Defaults::BLOG_SIDEBAR_DESCRIPTION
	]);
	
	$wp_customize->add_control('blog_sidebar__description', [
		'type'    => 'textarea',
		'section' => 'blog',
		'label'   => __('Опиание блога в сайдбаре', THEME_PREFIX),
	]);

	// Thumbnail
	$wp_customize->add_setting('blog_sidebar__thumbnail', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_THUMBNAIL,
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'postMessage'
	]);
	
	$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'blog_sidebar__thumbnail', [
		'label'    => __('Обложка блога', THEME_PREFIX),
		'section'  => 'blog_sidebar',
		'settings' => 'blog_sidebar__thumbnail',
		'description' => __('Загрузите изображение, учтите, что оно обрежется до пропорций 1:1', THEME_PREFIX),
	]));

	// Accent Button
	$wp_customize->add_setting('blog_sidebar__button1_icon', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_BUTTON1_ICON
	]);

	$wp_customize->add_control('blog_sidebar__button1_icon', [
		'type'    => 'select',
		'section' => 'blog_sidebar',
		'label'   => __('Иконка акцентной кнопки', THEME_PREFIX),
		'choices' => $icons_list,
	]);

	$wp_customize->add_setting('blog_sidebar__button1_name', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_BUTTON1_NAME
	]);

	$wp_customize->add_control('blog_sidebar__button1_name', [
		'type'    => 'text',
		'section' => 'blog_sidebar',
		'label'   => __('Текст акцентной кнопки', THEME_PREFIX),
	]);

	$wp_customize->add_setting('blog_sidebar__button1_link', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_BUTTON1_LINK
	]);

	$wp_customize->add_control('blog_sidebar__button1_link', [
		'type'    => 'text',
		'section' => 'blog_sidebar',
		'label'   => __('Ссылка акцентной кнопки', THEME_PREFIX),
	]);

	// Secondary Button
	$wp_customize->add_setting('blog_sidebar__button2_icon', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_BUTTON2_ICON
	]);

	$wp_customize->add_control('blog_sidebar__button2_icon', [
		'type'    => 'select',
		'section' => 'blog_sidebar',
		'label'   => __('Иконка дополнительной кнопки', THEME_PREFIX),
		'choices' => $icons_list,
	]);

	$wp_customize->add_setting('blog_sidebar__button2_name', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_BUTTON2_NAME
	]);

	$wp_customize->add_control('blog_sidebar__button2_name', [
		'type'    => 'text',
		'section' => 'blog_sidebar',
		'label'   => __('Текст дополнительной кнопки', THEME_PREFIX),
	]);

	$wp_customize->add_setting('blog_sidebar__button2_link', [
		'default'           => Theme_Defaults::BLOG_SIDEBAR_BUTTON2_LINK
	]);

	$wp_customize->add_control('blog_sidebar__button2_link', [
		'type'    => 'text',
		'section' => 'blog_sidebar',
		'label'   => __('Ссылка дополнительной кнопки', THEME_PREFIX),
	]);
});
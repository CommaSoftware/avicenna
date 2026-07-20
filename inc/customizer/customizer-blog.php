<?php
add_action('customize_register', function($wp_customize) {

	$wp_customize->add_section('blog', [
		'title'    => 'Раздел «Публикации»',
		'description' => 'Общие настройки раздела',
		'priority' => 10,
		'panel' => 'sections_panel'
	]);

	// Heading
	$wp_customize->add_setting('blog__heading', [
		'default'           => Theme_Defaults::BLOG_HEADING
	]);

	$wp_customize->add_control('blog__heading', [
		'type'    => 'text',
		'section' => 'blog',
		'label'   => __('Заголовок', THEME_PREFIX),
	]);

	// Link
	$wp_customize->add_setting('blog__link', [
		'default'           => Theme_Defaults::BLOG_LINK
	]);

	$wp_customize->add_control('blog__link', [
		'type'        => 'text',
		'section'     => 'blog',
		'label'       => __('Ссылка на раздел', THEME_PREFIX),
		'description' => __('Укажите ссылку на страницу Блога', THEME_PREFIX),
	]);

	// Answer to Empty
	$wp_customize->add_setting('blog__answer_to_empty', [
		'default'           => Theme_Defaults::BLOG_ANSWER_TO_EMPTY
	]);

	$wp_customize->add_control('blog__answer_to_empty', [
		'type'        => 'text',
		'section'     => 'blog',
		'label'       => __('Текст при отсутствии материалов', THEME_PREFIX),
		'description' => __('Укажите текст, который будет отображаться, если публикации для раздела не найдены. Особенно актуально для Рубрик', THEME_PREFIX),
	]);

	// Show FAQs in blog
	$wp_customize->add_setting( 'blog__show_faqs', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::BLOG_SHOW_FAQS,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'blog__show_faqs', array(
		'label'       => __( 'Отображать «Вопросы и ответы» в блоге', THEME_PREFIX ),
		'description' => __( 'Для корректной работы рубрика должна иметь ярлык "faqs"', THEME_PREFIX ),
		'section'     => 'blog',
		'type'        => 'checkbox',
	) );
});
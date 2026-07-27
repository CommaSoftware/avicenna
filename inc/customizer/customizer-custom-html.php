<?php
add_action('customize_register', function($wp_customize) {
	$wp_customize->add_section('custom_html', [
		'title'    => 'Блок с произвольным кодом',
		'priority' => 52,
		'panel' => 'sections_panel'
	]);

	// Show block
	$wp_customize->add_setting( 'custom_html__show', array(
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => Theme_Defaults::CUSTOM_HTML_SHOW,
		'sanitize_callback' => 'sanitize_checkbox',
	) );
	
	$wp_customize->add_control( 'custom_html__show', array(
		'label'       => __( 'Отображать блок на гравной странице', THEME_PREFIX ),
		'section'     => 'custom_html',
		'type'        => 'checkbox',
	) );

	// Code
	$wp_customize->add_setting('custom_html__code',[
			'default' => Theme_Defaults::CUSTOM_HTML_CODE,
	]);
	$wp_customize->add_control(
		'custom_html__code',
		array(
			'label' => __('HTML код', THEME_PREFIX),
			'description' => __('Будьте внимательны! Встраивайте только код, в безопасности которого уверены!', THEME_PREFIX),
			'section' => 'custom_html',
			'settings' => 'custom_html__code',
			'type' => 'textarea',
		)
	);
});
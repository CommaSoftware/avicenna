<?php

// --- Add Post Thumbnails ---
add_theme_support( 'post-thumbnails' ); 


// --- New excerpt size length ---
function wph_excerpt_length($length) {
	return 30; 
}
add_filter('excerpt_length', 'wph_excerpt_length');

add_filter('excerpt_more', function($more) {
	return '…';
});

// --- Hide admin bar for subscribers ---
if ( current_user_can( 'subscriber' ) ) {
	show_admin_bar( false );
}

// --- Enabling excerpt support for pages ---
add_action('init', 'add_excerpt_support_for_pages');
function add_excerpt_support_for_pages() {
	add_post_type_support('page', 'excerpt');
}


// --- Config redirects for filials ---
add_filter('redirect_canonical', 'custom_disable_redirect_canonical', 10, 2);

function custom_disable_redirect_canonical($redirect_url, $requested_url) {
	// Проверяем, что мы находимся на странице нашего типа записи 'filial'
	if (is_singular('filial')) {
		return false; // Полностью отключаем канонический редирект для этого CPT
	}
	return $redirect_url;
}

add_action('template_redirect', 'redirect_filials_to_hash');
function redirect_filials_to_hash() {
	if (is_page('filials') || $_SERVER['REQUEST_URI'] == '/filials' || $_SERVER['REQUEST_URI'] == '/filials/') {
		wp_redirect(home_url('/#filials'), 301);
		exit;
	}
}

// --- Add role with editor+customizer permissions ---
function add_custom_editor_role_precise() {
	// Создаем массив прав на основе редактора
	$editor_caps = array(
		// Базовые права редактора
		'read' => true,
		'edit_posts' => true,
		'edit_others_posts' => true,
		'edit_published_posts' => true,
		'publish_posts' => true,
		'delete_posts' => true,
		'delete_others_posts' => true,
		'delete_published_posts' => true,
		'edit_pages' => true,
		'edit_others_pages' => true,
		'edit_published_pages' => true,
		'publish_pages' => true,
		'delete_pages' => true,
		'delete_others_pages' => true,
		'delete_published_pages' => true,
		'manage_categories' => true,
		'manage_links' => true,
		'moderate_comments' => true,
		'upload_files' => true,
		'export' => true,
		'import' => true,
		
		// Права для Customizer
		'customize' => true,
		'edit_theme_options' => true,
		
		// Ограничения - запрещаем доступ к настройкам плагинов и обновлениям
		'activate_plugins' => false,
		'deactivate_plugins' => false,
		'update_plugins' => false,
		'install_plugins' => false,
		'delete_plugins' => false,
		'update_themes' => false,
		'install_themes' => false,
		'delete_themes' => false,
		'update_core' => false,
		'manage_options' => false,
	);
	
	add_role(
		'custom_editor_with_customizer',
		'Редактор + Настройки темы',
		$editor_caps
	);
}

add_action('after_switch_theme', 'add_custom_editor_role_precise');

function restrict_customizer_sections($wp_customize) {
	if (current_user_can('custom_editor_with_customizer')) {
		$wp_customize->remove_section('custom_css');
		$wp_customize->remove_section('background_image');
	}
}
add_action('customize_register', 'restrict_customizer_sections', 100);


// --- Hide comments (not permament diasble) ---
function disable_comments_post_types_support() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		if (post_type_supports($post_type, 'comments')) {
			remove_post_type_support($post_type, 'comments');
			remove_post_type_support($post_type, 'trackbacks');
		}
	}
}
add_action('init', 'disable_comments_post_types_support', 100);

function disable_existing_comments() {
	global $wpdb;
	
	$wpdb->update(
		$wpdb->posts,
		array('comment_status' => 'closed'),
		array('comment_status' => 'open'),
		array('%s'),
		array('%s')
	);
	
	$wpdb->update(
		$wpdb->posts,
		array('ping_status' => 'closed'),
		array('ping_status' => 'open'),
		array('%s'),
		array('%s')
	);
}
add_action('wp_loaded', 'disable_existing_comments');

function disable_comments_admin_redirect() {
	global $pagenow;
	if ($pagenow === 'edit-comments.php') {
		wp_redirect(admin_url());
		exit;
	}
}
add_action('admin_init', 'disable_comments_admin_redirect');

function disable_comments_admin_menu() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'disable_comments_admin_menu');

function disable_comments_dashboard_widget() {
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'disable_comments_dashboard_widget');

function disable_comments_admin_columns($columns) {
	unset($columns['comments']);
	return $columns;
}
add_filter('manage_posts_columns', 'disable_comments_admin_columns');
add_filter('manage_pages_columns', 'disable_comments_admin_columns');

function disable_comments_rest_api() {
	add_filter('rest_allow_anonymous_comments', '__return_false');
}
add_action('rest_api_init', 'disable_comments_rest_api');

function disable_comments_meta_box() {
	remove_meta_box('commentsdiv', null, 'normal');
	remove_meta_box('trackbacksdiv', null, 'normal');
}
add_action('admin_menu', 'disable_comments_meta_box');
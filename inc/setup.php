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
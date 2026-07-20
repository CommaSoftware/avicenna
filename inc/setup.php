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
<?php

function theme_register_nav_menu() {
	register_nav_menus([
	'header_menu' => 'Меню области шапки',
	'footer_menu' => 'Меню области подвала',
	]);
}
add_action( 'after_setup_theme', 'theme_register_nav_menu' );
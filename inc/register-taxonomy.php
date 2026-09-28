<?php

function register_taxonomy_service_types() {
	$labels = array(
	"name" => __('Тип услуги', 'service_types'),
	"singular_name" => __('Тип услуги', 'service_types'),
	"all_items" => __('Все типы услуг', 'all_service_types'),
	"edit_item" => __('Изменить тип услуги', 'edit_service_type'),
	"view_item" => __('Посмотреть тип услуги', 'view_service_type'),
	"update_item" => __('Обновить тип услуги', 'update_service_type'),
	"add_new_item" => __('Добавить', 'add'),
	"new_item_name" => __('Новый', 'new'),
	);
	$args = array(
	"label" => __( 'Индустрии', 'service_types'),
	"labels" => $labels,
	"public" => true,
	"hierarchical" => true,
	"show_ui" => true,
	"show_in_menu" => true,
	"show_in_nav_menus" => true,
	"query_var" => true,
	"rewrite" => false,
	"show_admin_column" => true,
	"rest_base" => "",
	"show_in_quick_edit" => true,
	'show_in_rest' => true,
	);
	register_taxonomy("service_types", array("service"), $args);
}
add_action( 'init', 'register_taxonomy_service_types' );

?>
<?php
function register_post_types(){
	register_post_type( 'filial', [
		'label'  => null,
		'labels' => [
			'name'               => 'Филиалы', // the main name for the record type
			'singular_name'      => 'Филиал', // name for one record of this type
			'add_new'            => 'Добавить Филиал', // to add a new entry
			'add_new_item'       => 'Добавление Филиала', // the title of the newly created entry in the admin panel
			'edit_item'          => 'Редактирование Филиала', // to edit the record type
			'new_item'           => 'Новый геренатор', // text of the new entry
			'view_item'          => 'Просмотр Филиала', // to view a record of this type
			'search_items'       => 'Искать Филиал', // to search for these types of records
			'not_found'          => 'Не найдено', // if nothing was found in the search result
			'not_found_in_trash' => 'Не найдено в корзине', // if it was not found in the trash
			'menu_name'          => 'Филиалы', // menu name
		],
		'description'         => '',
		'public'              => true,
		'show_in_menu'        => true, // whether to show it in the admin menu
		'show_in_admin_bar'   => true, // depends on show_in_menu
		'show_in_rest'        => true, // add to the REST API. C WP 4.7
		'rest_base'           => 'filial', // $post_type. C WP 4.7
		'menu_position'       => null,
		'menu_icon'           => null,
		'hierarchical'        => false,
		'supports'            => ['title', 'thumbnail', 'editor', 'author'], // 'title','editor','author','excerpt','trackbacks','comments','revisions','page-attributes','post-formats'
		'has_archive'         => true,
		'rewrite'             => ['slug' => '/filials'],
		'feeds'               => false,
		'query_var'           => true,
		'menu_icon'           => 'dashicons-admin-multisiteя',
	]);
	register_post_type('employee', [
		'labels' => [
        'name'               => 'Сотрудники',
        'singular_name'      => 'Сотрудник',
        'menu_name'          => 'Сотрудники',
        'add_new'            => 'Добавить Сотрудник',
        'add_new_item'       => 'Добавить нового',
        'edit_item'          => 'Редактировать Сотрудника',
        'new_item'           => 'Новый Сотрудник',
        'view_item'          => 'Просмотреть Сотрудник',
        'search_items'       => 'Искать Сотрудники',
        'not_found'          => 'Сотрудники не найдены',
        'not_found_in_trash' => 'В корзине нет Сотрудников',
		],
		'public'              => false, // Только для админов
		'publicly_queryable'  => true,
		'exclude_from_search' => true,
		'show_ui'             => true, // Показываем в админке
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true, // add to the REST API. C WP 4.7
		'rest_base'           => 'employee',
		'capability_type'     => 'post',
		'capabilities' => [
				'create_posts' => 'manage_options', // Только администраторы
		],
		'map_meta_cap'        => true,
		'hierarchical'        => false,
		'supports'            => ['title', 'thumbnail', 'editor', 'author'], // Комментарии для отчётов
		'has_archive'         => false,
		'rewrite'             => ['slug' => '/employee'],
		'query_var'           => false,
		'menu_icon'           => 'dashicons-id-alt',
		'menu_position'       => 25,
	]);
}
add_action( 'init', 'register_post_types' );
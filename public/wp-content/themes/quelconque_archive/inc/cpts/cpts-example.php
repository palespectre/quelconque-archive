<?php

add_action( 'init', function() {

	$args = array (
		'label' => esc_html__( 'Vans', TEXTDOMAIN ),
		'labels' => array(
			'menu_name' => esc_html__( 'Vans', TEXTDOMAIN ),
			'name_admin_bar' => esc_html__( 'Van', TEXTDOMAIN ),
			'add_new' => esc_html__( 'Ajouter un nouveau', TEXTDOMAIN ),
			'add_new_item' => esc_html__( 'Ajouter un nouveau van', TEXTDOMAIN ),
			'new_item' => esc_html__( 'Nouveau Van', TEXTDOMAIN ),
			'edit_item' => esc_html__( 'Editer le Van', TEXTDOMAIN ),
			'view_item' => esc_html__( 'Voir le Van', TEXTDOMAIN ),
			'update_item' => esc_html__( 'Update Van', TEXTDOMAIN ),
			'all_items' => esc_html__( 'Tous les Vans', TEXTDOMAIN ),
			'search_items' => esc_html__( 'Chercher un Van', TEXTDOMAIN ),
			'parent_item_colon' => esc_html__( 'Van parent', TEXTDOMAIN ),
			'not_found' => esc_html__( 'Aucun Van trouvé', TEXTDOMAIN ),
			'not_found_in_trash' => esc_html__( 'Aucun Van dans la Corbeille', TEXTDOMAIN ),
			'name' => esc_html__( 'Vans', TEXTDOMAIN ),
			'singular_name' => esc_html__( 'Van', TEXTDOMAIN ),
		),
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'show_in_rest' => true,
		'menu_icon' => 'dashicons-cart',
		'capability_type' => 'post',
		'hierarchical' => false,
		'has_archive' => 'nos-vans',
		'query_var' => false,
		'can_export' => true,
		'supports' => array(
			'title',
			'thumbnail',
		),
		'rewrite' => array(
			'with_front' => false,
		),
	);

	register_post_type( 'van', $args );

});
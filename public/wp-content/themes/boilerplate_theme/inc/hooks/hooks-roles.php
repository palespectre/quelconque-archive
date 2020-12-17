<?php

// Roles personnalisés

add_action('init', function () {

    global $wp_roles;

    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();

    $wp_roles->roles['administrator']['name'] = __('Administrateur technique', TEXTDOMAIN);
    $wp_roles->role_names['administrator'] = __('Administrateur technique', TEXTDOMAIN);

	remove_role('administrator_content');
	add_role('administrator_content', __(
	 	'Administrateur contenus'),
		array(

			'read' => true,

			 'create_posts' => true, // Allows user to create new posts
			 'edit_posts' => true, // Allows user to edit their own posts
			 'edit_post' => true, // Allows user to edit their own posts
			 'edit_others_posts' => true, // Allows user to edit their own posts
			 'delete_posts' => true,
			 'publish_posts' => true,
			 'edit_others_posts' => true,
			 'edit_published_posts' => true,

			 'publish_testimonials' => false,
			 'edit_testimonials' => false,

			 'edit_pages' => true,
			 'delete_pages' => true,
			 'delete_others_pages' => true,
			 'delete_published_pages' => true,
			 'edit_others_pages' => true,
			 'edit_published_pages' => true,
			 'publish_pages' => true,

			 'shop_order' => true,
			 'order_again' => true,
			 'view_admin_dashboard' => true,
			 'view_woocommerce_reports' => true,
			 'woocommerce_order_itemmeta' => true,
			 'woocommerce_order_items' => true,
			 'woocommerce_view_order' => true,

			 'upload_files' => true,

			 'list_users' => true,
			 'remove_users' => true,
			 'add_users' => true,
			 'promote_users' => true,
			 'edit_users' => true,
			 'create_users' => true,
			 'delete_users' => true,

			 'manage_woocommerce' => true,
			 'manage_options' => false,
			 'view_woocommerce_reports' => true,

			 'cf7_edit_forms' => false,
			 'cf7_read_forms' => false,
			 'cf7_delete_forms' => false,
			 'cf7_manage_integration' => false,
			 'wpcf7_read_contact_forms' => false,
			 'wpcf7_edit_contact_forms' => false,

		)
	);

		$capabilities = array();

		$capabilities['core'] = array(
			'manage_woocommerce',
			'view_woocommerce_reports',
		);

		$capability_types = array( 'product', 'shop_order', 'shop_coupon' );

		foreach ( $capability_types as $capability_type ) {

			$capabilities[ $capability_type ] = array(
				// Post type.
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",

				// Terms.
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms",
			);
		}

		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->add_cap( 'administrator_content', $cap );
			}
		}	

});


add_action( 'admin_menu', function () {
    if ( current_user_can('administrator_content') ) {
        remove_menu_page( 'edit.php?post_type=testimonials' );
        remove_menu_page( 'edit.php?post_type=gallery' );
        remove_menu_page( 'edit.php?post_type=menu' );
        remove_menu_page( 'edit.php?post_type=events' );
        remove_menu_page( 'edit.php?post_type=sliders' );
        remove_menu_page( 'edit.php?post_type=mb-post-type' );
        remove_menu_page( 'admin.php?page=vc-welcome' );
        remove_menu_page( 'vc-welcome' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'edit.php' );
		remove_menu_page( 'wc-reports' );
    }
});

add_action('add_meta_boxes', function () {

	$screen = get_current_screen();
	if ( !$screen || current_user_can('administrator') ) {
		return;
	}

	//Hide the "SEO" meta box.
	remove_meta_box('seopress_cpt', $screen->id, 'normal');
	//Hide the "Content analysis" meta box.
	remove_meta_box('seopress_content_analysis', $screen->id, 'normal');
});
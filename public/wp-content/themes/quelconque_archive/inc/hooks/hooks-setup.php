<?php

if ( ! function_exists( 'dh_setup' ) ){

	add_action( 'after_setup_theme', 'dh_setup' );
	function dh_setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on twentyfifteen, use a find and replace
		 * to change 'twentyfifteen' to the name of your theme in all the template files
		 */
		load_theme_textdomain( TEXTDOMAIN, get_template_directory() . '/languages' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 200, 200, true );

		// Ajout des tailles d'images par défaut pour le responsive
		add_image_size('xlrg', 1600);
		add_image_size('lrg', 1200);
		add_image_size('med', 748);
		add_image_size('sml', 320);
		add_image_size('placeholder', 3, 3);

		// Enregistrement des nouveaux emplacements de menu
		register_nav_menus( array(
			'loggedin' => __( 'Connecté',      TEXTDOMAIN ),
			'loggedout' => __( 'Déconnecté',      TEXTDOMAIN ),
			'commerce' => __( 'Commerce',      TEXTDOMAIN ),
			'supheader' => __( 'Sup Header',      TEXTDOMAIN ),
			'primary' => 'Menu principal',
			'mobile' => __( 'Menu mobile',      TEXTDOMAIN ),
			'subfooter' => __( 'Subfooter',      TEXTDOMAIN ),
		) );

		// Enregistrement des nouvelles sidebars
		/*
		if ( function_exists( 'register_sidebar' ) ) {

			register_sidebar(
				array(
					'name' => __( 'Général', TEXTDOMAIN ),
					'id' => 'general',
					'before_widget' => '<div class="widget padded">',
					'after_widget' => '</div>',
					'before_title' => '<h3>',
					'after_title' => '</h3>',
				)
			);	
			
		}
		*/

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );
	}
}
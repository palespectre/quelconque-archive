<?php

function scripts() {

	global $is_IE;

	/**
	*	Styles
	*/
	wp_enqueue_style( 'dh-main', get_stylesheet_directory_uri().'/assets/css/main.css');
	wp_enqueue_style( 'leto-parent-style', get_template_directory_uri() . '/style.css' );
	
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Rubik&display=swap"');
	if(file_exists(get_stylesheet_directory().'/assets/css/large-mobile.css'))
		wp_enqueue_style( 'dh-large-mobile', get_stylesheet_directory_uri().'/assets/css/large-mobile.css', 'dh-main', '1.0', 'screen and (min-width: 36em)');
	if(file_exists(get_stylesheet_directory().'/assets/css/tablet.css'))
		wp_enqueue_style( 'dh-tablet', get_stylesheet_directory_uri().'/assets/css/tablet.css', 'dh-main', '1.0', 'screen and (min-width: 48em)');
	if(file_exists(get_stylesheet_directory().'/assets/css/desktop.css'))
		wp_enqueue_style( 'dh-desktop', get_stylesheet_directory_uri().'/assets/css/desktop.css', 'dh-main', '1.0', 'screen and (min-width: 64em)');
	if(file_exists(get_stylesheet_directory().'/assets/css/large-desktop.css'))
		wp_enqueue_style( 'dh-large-desktop', get_stylesheet_directory_uri().'/assets/css/large-desktop.css', 'dh-main', '1.0', 'screen and (min-width: 80em)');
	if(file_exists(get_stylesheet_directory().'/assets/css/xlarge-desktop.css'))
		wp_enqueue_style( 'dh-xlarge-desktop', get_stylesheet_directory_uri().'/assets/css/xlarge-desktop.css', 'dh-main', '1.0', 'screen and (min-width: 100em)');

	if ($is_IE && file_exists(get_stylesheet_directory().'/assets/css/ie.css')) {
		wp_enqueue_style( 'dh-ie', get_stylesheet_directory_uri().'/assets/css/ie.css');
	}

	/**
	*	Scripts
	*/

	// Intégrer lazy sizes : https://github.com/aFarkas/lazysizes
	// Intégrer mixitup : https://www.kunkalabs.com/mixitup/
	wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/assets/js/main.js', array(), '', true);
	wp_localize_script( 'dh-main', 'templateURL', get_template_directory_uri().'/');
	
	if ($is_IE) {
		wp_enqueue_script( 'dh-ie', get_stylesheet_directory() . '/assets/js/ie.js', array(), '', true);
		wp_localize_script( 'dh-ie', 'pathUrl', get_stylesheet_directory());
	}

}
add_action( 'wp_enqueue_scripts', 'scripts', 1 );
  
  
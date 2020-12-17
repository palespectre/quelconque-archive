<?php

/**
 * Inline critical CSS
 */
add_action('wp_head', function() {
	$filename  = get_template_directory() . '/assets/css/critical.css';
	$handle = fopen($filename, "r");
	$critical_css = fread($handle, filesize($filename));
	echo '<style>' . $critical_css . '</style>';
});

/**
 * Inline critical js
 */
add_action('wp_footer', function() {
    ?>
        <script>

        </script>
    <?php
});


function scripts() {

	global $is_IE;

	/**
	*	Styles
	*/
	
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

	wp_enqueue_style( 'style', get_stylesheet_uri());

	if ($is_IE && file_exists(get_stylesheet_directory().'/assets/css/ie.css')) {
		wp_enqueue_style( 'dh-ie', get_stylesheet_directory_uri().'/assets/css/ie.css');
	}

	/**
	*	Scripts
	*/

	// Intégrer lazy sizes : https://github.com/aFarkas/lazysizes
	// Intégrer mixitup : https://www.kunkalabs.com/mixitup/

	wp_enqueue_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.0.4/gsap.min.js', null, null, true );
	wp_enqueue_script( 'dh-main', get_template_directory_uri() . '/assets/js/main.js', array(), '', true);
	wp_localize_script( 'dh-main', 'pathUrl', get_template_directory_uri());
	
	if ($is_IE) {
		wp_enqueue_script( 'dh-ie', get_template_directory_uri() . '/assets/js/ie.js', array(), '', true);
		wp_localize_script( 'dh-ie', 'pathUrl', get_template_directory_uri());
	}

}
add_action( 'wp_enqueue_scripts', 'scripts', 1 );
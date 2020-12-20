<?php

/**
 * Création de la page d'option du thème si elle n'est pas déjà créé par un autre plugin (DaHive Accelerator...)
 */
add_filter( 'mb_settings_pages', function ( $settings_pages) {
    
	foreach($settings_pages as $sp)
		if($sp['id'] == 'theme-options' && $sp ['option_name'] == 'theme_options')
			return $settings_pages;

    $settings_pages[] = array(
        'id'          => 'theme-options',
        'option_name' => 'theme_options',
        'menu_title'  => 'Options du thème',
        'parent'      => 'themes.php',
    );


    return $settings_pages;
}, 99, 1);


add_filter( 'rwmb_meta_boxes', function ($meta_boxes) {
 

	$meta_boxes[] = array(
		'id'             => 'logos',
		'title'          => __( 'Logos', TEXTDOMAIN ),
		'settings_pages' => 'theme-options',
		'fields'         => array(
			array(
				'name' => __( 'Logo blanc', TEXTDOMAIN ),
				'id'   => 'logo_blanc',
				'type' => 'single_image',
			),
		),
	);

	return $meta_boxes;

});
<?php

add_action( 'wp_ajax_nom_action', 'nom_action', 10, 1 );
add_action( 'wp_ajax_nopriv_nom_action', 'nom_action', 10, 1 );
function nom_action() {

	$data = [];

	$json = json_encode($data);

	header('Content-type:application/json; charset=utf-8');
	
	wp_send_json($json);

}
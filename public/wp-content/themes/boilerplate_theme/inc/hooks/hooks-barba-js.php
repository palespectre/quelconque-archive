<?php

function barba_dontcache(){
	define('DONOTCACHEPAGE', false);//Super Cacche

	if( !empty($_SERVER['HTTP_X_BARBA'])){

		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		define('DONOTCACHEPAGE', true);//Super Cacche
		add_filter('bypass_cache', '__return_true');//Cache enabler
	}

}
add_action('init', 'barba_dontcache');
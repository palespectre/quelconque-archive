<?php

// Correction du bug dans les hreflangs générés par WPML
// Récupération en dur de l'URL des alternate links
add_filter( 'icl_ls_languages', 'my_custom_head_langs', 10, 2 );
function my_custom_head_langs( $ls_languages  ) {

	global $sitepress;

	if(is_archive()){

		global $post;

		$default_lang = $sitepress->get_default_language();

		foreach($ls_languages as $lang => &$l){

			$cpt = get_post_type_object($post->post_type);

			if(function_exists('wpc_archives_slug'))
				$slug = wpc_archives_slug($cpt, $lang);

			if($slug)
				$l['url'] = wpc_archives_permalinks(site_url($slug), $post->post_type);

		}
	}

    return $ls_languages;
 
}

// Correction du bug dans les canonical générés par Yoast
// Récupération en dur de l'URL des canonical
add_filter( 'wpseo_canonical', 'my_custom_wpseo_canonical', 10, 2 );
function my_custom_wpseo_canonical( $canonical ) {

	if(is_archive()){

		global $post;

		$cpt = get_post_type_object($post->post_type);

		if(function_exists('wpc_archives_slug'))
			$slug = wpc_archives_slug($cpt, ICL_LANGUAGE_CODE);

		if($slug)
			$canonical = wpc_archives_permalinks(site_url($slug), $post->post_type);

	}
    return $canonical;
 
}

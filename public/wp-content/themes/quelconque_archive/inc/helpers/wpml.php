<?php

//Masquer la langue en cours
function language_selector(){

	if(function_exists('icl_get_languages')){
		$html = '<ul class="language-selector">';
		$languages = icl_get_languages('skip_missing=0&orderby=code');
		if(!empty($languages)){
			foreach($languages as $l){
				if(!$l['active']) { 
					$html .= '<li><a href="'.$l['url'].'" class="no-barba"> ';
					$html .= $l['native_name'];
					$html .= '</a></li>';
				}
			}
		}

		echo $html.'</ul>';

	}
}

function wpml_get_permalink($id = null, $original = false){

	if(empty($id))
		$id = get_the_id();

	if(function_exists('icl_object_id'))
		return get_permalink(icl_object_id($id, get_post_type($id), $original));
	else
		return get_permalink($id);
	
}
<?php

/**
 * Fonctions de récupération et traitement des images
 *
 * @param      string    $img       ID de l'image à récupérer
 * @param      string    $params    Array des options de récupération
 * @return     string    HTML code for image or URL only
 */
function dh_get_img($img, $params = array()){

	$html = $img_HTMl = $attr_HTML = $wrapper_attr_HTML = '';
	$attributes = array();

	/*
		Définition des paramètres de sortie
	*/
	$params_default = [
		'base_size' => 'med', // Taille de l'image par défaut
		'placeholder_size' => 'placeholder', // Taille de l'image par défaut
		'mode' => 'image', // Mode image ou mode URL
		'srcset' => true, // Utiliser SRCSET
		'url_only' => false, // URL seule ou Full code HTML
		'lazy' => false,
		'decoding' => 'async',
		'include_svg' => false,
		'wrapper' => [
			'class' => 'image-wrapper'
		], // Array with 'HTML attribute' => Value
	];
	$params = array_merge($params_default, $params);

	/*
		Récupération de l'ID de l'image en fonction du type de paramètre passé
	*/
	$img_id = null;

	if(is_numeric($img))
		$img_id = $img;
	elseif(is_array($img) && !empty($img['ID']) )
		$img_id = $img['ID'];
	else
		return false;


	$src = wp_get_attachment_image_src($img_id, $params['base_size']);

	if($params['url_only'])
		return $src[0];

	// Si l'image est en mode lazy, il n'y a pas d'attribut SRC, mais un attribut DATA-SRC qui est utilisé en JS.
	$prefix_attributes = '';
	if(!empty($params['lazy']) ){
		$prefix_attributes = 'data-';
		$attributes['class'][] = 'lazy';
	}else{
		$attributes['class'][] = 'no-lazy';
	}

	$attributes[$prefix_attributes.'src'] = $src[0];

	if($params['srcset']){
		$attributes[$prefix_attributes.'srcset'] = wp_get_attachment_image_srcset($img_id);
		$attributes[$prefix_attributes.'sizes'] = '(max-width: 899px) 100vw, (min-width: 900px) 50vw, (max-width: 1200px) 33.33vw';
	}

	$attributes['width'] = $src[1];
	$attributes['height'] = $src[2];
	$attributes['data-ratio'] = $src[1] / $src[2];
	$attributes['class'] = ['image', 'mode-'.$params['mode'], 'size-'.$params['base_size']];
	$attributes['alt'] = get_post_meta( $img_id, '_wp_attachment_image_alt', true);
	$attributes['title'] = get_the_title( $img_id );
	$attributes['decoding'] = $params['decoding'];

	if($params['mode'] == 'image'){

		if(!is_svg( realpath(get_attached_file($img_id, true)) )){

			// On génère les attributs en HTML
			foreach($attributes as $name => $val)
				if(!empty($val))
					$attr_HTML .= $name.'="'.( is_array($val) ? implode(' ', $val) : $val ).'" ';

			$img_HTML = '<img '.$attr_HTML.' />';

		}else
			$img_HTML = dh_include_svg_from_id($img_id);

	}elseif($params['mode'] == 'background'){

		// On génère les attributs en HTML
		foreach($attributes as $name => $val)
			if(!empty($val))
				$attr_HTML .= $name.'="'.( is_array($val) ? implode(' ', $val) : $val ).'" ';

		$img_HTML = '<div '.$attr_HTML.' style="background-size:cover;background-image:url('.$attributes['src'].')"></div>';

	}

	if(!empty($params['wrapper'])){

		foreach($params['wrapper'] as $name => $val){
			$wrapper_attr_HTML .= $name.'="'.$val.'" ';
		}

		$src_thumb = _scaled_image_path($img_id, $params['placeholder_size']);

		$html .= '<div '.$wrapper_attr_HTML.' style="background-size:cover;background-image:url('._encode64($src_thumb).')">'.$img_HTML.'</div>';


	}else{
		$html .= $img_HTML;
	}

	return $html;

}

/*
	Encode en base64 une image à partir de son URI
*/
function _encode64($image){

	$dataUri = '';
	if(!empty($image)){
		$type = pathinfo($image, PATHINFO_EXTENSION);
		$data = file_get_contents($image);
		$dataUri = 'data:image/' . $type . ';base64,' . base64_encode($data);
	}

	return $dataUri;
}

/**
 *	Retourne l'URI du fichier image demandé
 *	@param int attachment_id : id de l'image attachée
 *	@param string size : taille WP demandée
 */
function _scaled_image_path($attachment_id, $size = 'thumbnail') {
    $file = get_attached_file($attachment_id, true);
    if (empty($size) || $size === 'full') {
        // for the original size get_attached_file is fine
        return realpath($file);
    }
    if (! wp_attachment_is_image($attachment_id) ) {
        return false; // the id is not referring to a media
    }
    $info = image_get_intermediate_size($attachment_id, $size);
    if (!is_array($info) || ! isset($info['file'])) {
        return false; // probably a bad size argument
    }

    return realpath(str_replace(wp_basename($file), $info['file'], $file));
}

function is_svg($filePath){
	return 'image/svg+xml' === mime_content_type($filePath);
}

/*
	Include SVG code in HTML from the attachment id
	@id : ID of the attachement
*/
function dh_include_svg_from_id($id){

	if(empty($id))
		return false;

	$file = get_attached_file($id, true);

	if(empty($file))
		return false;

	return dh_include_svg_from_uri($file);
}

function dh_include_svg_from_uri($uri){

	if(empty($uri))
		return false;

	$prefix = '<!-- Filtered SVG by Image Helper -->';
	$contents = file_get_contents(realpath($uri));

	// Suppression des sauts de ligne
	$contents = preg_replace("/[\n\r]/", '', $contents);

	// Suppression des <g> vides
	$tags_to_strip = ['g'];
	foreach ($tags_to_strip as $tag){
	    $contents = preg_replace("/<".$tag."><\/".$tag.">/",'',$contents);
	}

	return $prefix.$contents;
}
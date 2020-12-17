<?php

function barba_get_namespace(){
	global $query;
	global $post;

	$namespace = '';

	if(!empty($query->original) && $query->original->is_post_type_archive)
		$namespace .= 'archive-'.$query->original->query['post_type'];
	elseif(is_archive())
		$namespace .= 'archive-'.$post->post_type;
	elseif(is_page_template())
		$namespace .= str_replace('.php', '', get_page_template_slug($post->ID));
	elseif(is_404())
		$namespace .='error-page';	
	elseif(is_front_page())
		$namespace .='front-page';
	else
		$namespace .= $post->post_type;

	return $namespace;
}

function barba_get_header($body_classes = ''){

	global $post;

	if( empty($_SERVER['HTTP_X_BARBA']) || DONOTCACHEPAGE == false/* || $_SERVER['HTTP_REFERER'] == get_permalink($post->ID)*/){
		get_header();
		echo '<div data-barba="container" class="'.$body_classes.' '.join( ' ',get_body_class('barba-container')).'" data-namespace="'.barba_get_namespace().'">';
	}else{

		/**
		 * Compatibilité pour SEO Press
		 * Nous appelons la fonction principale wp_head dans le header barba en ne gardant que les filtres utiles
		 * 
		 */
		global $wp_filter;
		if($wp_filter['wp_head']->callbacks){
			foreach($wp_filter['wp_head']->callbacks as &$priority){
				foreach($priority as $filter_name => $filter){
					if(!in_array($filter_name, ['_wp_render_title_tag', 'seopress_load_titles_options', 'seopress_pro_breadcrumbs'])){
						unset( $priority[$filter_name] );
						remove_filter('wp_head', $filter_name);
					}
				}

			}
		}
		wp_head();

		echo'<body><div data-barba="container" class="'.$body_classes.' '.join( ' ',get_body_class('barba-container')).'"  data-namespace="'.barba_get_namespace().'">';

	}
}

function barba_get_footer(){

	global $post;

	if( empty($_SERVER['HTTP_X_BARBA']) || DONOTCACHEPAGE == false/* || $_SERVER['HTTP_REFERER'] == get_permalink($post->ID)*/ ){
		echo '</div>';
	  get_footer();
	}else{
		$html = '</div></body>';

		echo $html;
	}

}
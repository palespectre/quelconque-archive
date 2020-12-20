<?php
/**
 * Dans le contexte ou les URLS des CPTS et taxo sont de la forme /CPTS/Taxo/Post :
 * Autorise l'accès à une Child Page d'une page dont le slug correspond au rewrite de la taxo
 *
 */

add_action( 'pre_get_posts', 'pre_get_cpt_taxonomy_url_childpage', 1 );
function pre_get_cpt_taxonomy_url_childpage( $query ) {

    if ( is_admin() || !$query->is_main_query() ) {
        return;
    }

	/**
	* On garde en mémoire les paramètres de la requête originale pour pouvoir la réutilisaer plus tard
	*/
	$query->original = clone $query;

    if($query->is_tax){

		$taxonomy_name = $query->tax_query->queries[0]['taxonomy'];

		if(taxonomy_exists($taxonomy_name)){

			$taxonomy = get_taxonomy( $taxonomy_name );

			$rewrite_root = $taxonomy->rewrite['slug'] ? $taxonomy->rewrite['slug'].'/' : null;
			$page_path = $rewrite_root.$query->query[$taxonomy_name];

			if(get_page_by_path($page_path)){

			    // query dedicated page instead of archive
			    $query->set( 'post_type', 'page' );
			    $query->set( 'pagename', $page_path );
			    $query->is_archive = false;
			    $query->is_post_type_archive = false;
			    $query->is_page = true;
			    $query->is_singular = true;
			    $query->is_tax = false;
			}
		}

	}elseif(!empty($query->query_vars['post_type']) && !in_array($query->query_vars['post_type'], ['post','page','attachment']) ){

		$rewrite_root = '';
		$post_name = isset($query->query['name']) ? $query->query['name'] : '';

		$cpt = get_post_type_object( $query->query['post_type'] );

		if($cpt && !empty($cpt->rewrite['slug']) ){

			preg_match('/%(.*?)%/', $cpt->rewrite['slug'], $taxonomy_replaced_in_url);

			if($taxonomy_replaced_in_url){

		        $rewrite_root = str_replace( $taxonomy_replaced_in_url[0] ,$query->query[$taxonomy_replaced_in_url[1]], $cpt->rewrite['slug'] ).'/';

		    }else
		    	$rewrite_root = $cpt->rewrite['slug'];
	  	}

	  	$page_path = $rewrite_root.$post_name;

		if(get_page_by_path($page_path)){

		    if($query->is_post_type_archive){
		    	$q = $query;
		    			       		
		       	add_filter( 'template_include', function() use($q){ 
		       		global $query; 
		       		$query = $q; 
		       		return locate_template( array( 'archive-'.$q->query['post_type'].'.php', 'archive.php', 'index.php' ) );
		       	}, 99 );
		    }

		    // query dedicated page instead of archive
		    $query->set( 'post_type', 'page' );
		    $query->set( 'pagename', $page_path );
		    $query->is_archive = false;
		    $query->is_post_type_archive = false;
		    $query->is_original_post_type_archive = $q->query['post_type'];
		    $query->is_page = true;
		    $query->is_singular = true;
		    $query->is_tax = false;
		}

	}

}

/**
 * Mise à jour des URLs dans le cas où le slug rewrite intègre le nom d'une taxonomy
 * EX : 'slug' => 'sejours/%sejour_categories%'
 */

add_filter( 'post_type_archive_link', 'show_permalinks_cpt_taxonomy_url', 1, 2 );
add_filter( 'post_type_link', 'show_permalinks_cpt_taxonomy_url', 1, 2 );
function show_permalinks_cpt_taxonomy_url( $post_link, $post ){

	$post_type = is_object( $post ) ? get_post_type($post) : $post;

	$cpt = get_post_type_object( $post_type );

	if($cpt && !empty($cpt->rewrite['slug']) ){

		preg_match('/%(.*?)%/', $cpt->rewrite['slug'], $taxonomy_replaced_in_url);

		if($taxonomy_replaced_in_url){

	        $terms = wp_get_object_terms( $post->ID, $taxonomy_replaced_in_url[1] );
	        
	        if( $terms )
	          return str_replace( $taxonomy_replaced_in_url[0] , $terms[0]->slug , $post_link );
	     	else
	     		return str_replace( $taxonomy_replaced_in_url[0].'/' , '' , $post_link );

	     }
  	}
    
    return $post_link;
}

/**
 * Dans le contexte ou les URLS des CPTS et taxo sont de la forme /CPTS/Taxo/Post :
 * Ajouts des liens intermédiaires dans le breadcrum
 *
 */
add_filter('wpseo_breadcrumb_links','filter_breadcrumb_parents_cpt_taxonomy_url',10,2);
function filter_breadcrumb_parents_cpt_taxonomy_url($parents){

	global $cpts;
	global $post;
	global $query;

	$insert = array();

	if(is_tax()){

		$insert[] = array('ptarchive' => get_post_type() );

	}else{

		$pt = get_post_type_object( get_post_type($post) );

		if($pt && !empty($pt->rewrite['slug']) ){

			preg_match('/%(.*?)%/', $pt->rewrite['slug'], $taxonomy_replaced_in_url);

	        $terms = wp_get_object_terms( $post->ID, $taxonomy_replaced_in_url[1] );
	        if( $terms )
	        	$insert[] = array('term' => $terms[0] );
	  	}

		
	}

	if(!empty($insert))
		array_splice($parents, -1, 0, $insert);//On ajoute les pages Produits et Produit X dans le breadcrumb
	
	return $parents;

}

add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');
function taxonomy_slug_rewrite($wp_rewrite) {
    $rules = array();
    // get all custom taxonomies
    $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
    // get all custom post types
    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');
     
    foreach ($post_types as $post_type) {
        foreach ($taxonomies as $taxonomy) {
            // go through all post types which this taxonomy is assigned to
            foreach ($taxonomy->object_type as $object_type) {
                
                // check if taxonomy is registered for this custom type
                if ($object_type == $post_type->name) {

                    // get category objects
                    $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));
             
                    // make rules
                    foreach ($terms as $term) {
                        $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
                    }
                }
            }
        }
    }

    // merge with global rules
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
}
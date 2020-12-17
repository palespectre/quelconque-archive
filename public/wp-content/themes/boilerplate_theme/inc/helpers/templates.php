<?php

if ( ! function_exists( 'dh_get_partial' ) ) :

/**
 * Load given template with arguments as array.
 * arguments. 
 * See get_template_part().
 * http://wordpress.stackexchange.com/a/103257
 */
function dh_get_partial( $slug = null, $name = null, array $params = array(), $prefix = null ) {
    global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    /**
     * Fires before the specified template part file is loaded.
     *
     * The dynamic portion of the hook name, `$slug`, refers to the slug name
     * for the generic template part.
     *
     * @param string $slug The slug name for the generic template.
     * @param string $name The name of the specialized template.
     */
    do_action( "get_partial_{$slug}", $slug, $name );
    do_action( "get_template_part_{$slug}", $slug, $name );

    $templates = array();
    $name = (string) $name;
    if ( '' !== $name ) {
        $templates[] = "{$slug}-{$name}.php";
    }

    $templates[] = "{$slug}.php";

    $_template_file = locate_template( $templates, false, false );

    if ( is_array( $wp_query->query_vars ) ) {
        extract( $wp_query->query_vars, EXTR_SKIP );
    }

    if ( isset( $s ) ) {
        $s = esc_attr( $s );
    }

    if ( ! is_null( $prefix ) ) {
        $flags = EXTR_PREFIX_ALL;
        // ensure prefix doesn't end with an underscore, it is automatically added by extract()
        if ( '_' === $prefix[ strlen( $prefix ) - 1 ] ) {
            $prefix = substr( $prefix, 0, -1 );
        }
    } else {
        $flags = EXTR_PREFIX_SAME;
        $prefix = '';
    }
    
    extract( $params, $flags, $prefix );

    require( $_template_file );
}

endif;

/**
    Pagination
*/
function dh_numeric_posts_nav($args = []) {
    $args = array_merge([
        'ul_class' => 'pagination center',
        'li_current_class' => '',
        'prev_class' => 'previous_page',
        'prev_content' => 'Précédent',
        'next_class' => 'next_page',
        'next_content' => 'Suivant',
    ], $args);

    if( is_singular() )
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
    $max   = intval( $wp_query->max_num_pages );

    /** Add current page to the array */
    if ( $paged >= 1 )
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ( $paged >= 3 ) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if ( ( $paged + 2 ) <= $max ) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<ul class="'.$args['ul_class'].'">';

    /** Previous Post Link */
    if ( get_previous_posts_link() )
        printf( '<li>%s</li>' . "\n", get_previous_posts_link($args['prev_content']) );

    /** Link to first page, plus ellipses if necessary */
    if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="'.$args['li_current_class'].'"' : ' class="waves-effect"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort( $links );
    foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="'.$args['li_current_class'].'"' : ' class="waves-effect"';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
    }

    /** Link to last page, plus ellipses if necessary */
    if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="'.$args['li_current_class'].'"' : ' class="waves-effect"';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
    }

    /** Next Post Link */
    if ( get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", get_next_posts_link($args['next_content']) );

    echo '</ul>' . "\n";

}
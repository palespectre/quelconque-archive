<?php

// stock message
add_filter('woocommerce_get_stock_html', 'change_stock_message', 10, 2);
function change_stock_message($message, $stock_status) {
    if ($stock_status->get_stock_status() == "outofstock") {
        $message = '<p class="stock out-of-stock">Sold</p>';    
    }
    return $message;
}

// display an 'Out of Stock' label on archive pages
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_stock', 10 );
function woocommerce_template_loop_stock() {
    global $product;
    if ($product->get_stock_status() === 'outofstock') {
        echo '<p class="is-out-of-stock">Sold</p>';
    }
}

// // display filters
// add_action( 'woocommerce_before_shop_loop', 'woocommerce_filters', 10 );
// function woocommerce_filters() {
//     echo do_shortcode('[br_filter_single filter_id=76]');
// }

// remove related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

// rename product tags' label
add_filter( 'woocommerce_taxonomy_args_product_tag', 'custom_wc_taxonomy_args_product_tag' );
function custom_wc_taxonomy_args_product_tag( $args ) {
	$args['label'] = __( 'Designers', 'woocommerce' );
	$args['labels'] = array(
	    'name' 				=> __( 'Designers', 'woocommerce' ),
	    'singular_name' 	=> __( 'Product Designer', 'woocommerce' ),
        'menu_name'			=> _x( 'Designers', 'Admin menu name', 'woocommerce' ),
	    'search_items' 		=> __( 'Search Product Designers', 'woocommerce' ),
	    'all_items' 		=> __( 'All Product Designers', 'woocommerce' ),
	    'parent_item' 		=> __( 'Parent Product Designer', 'woocommerce' ),
	    'parent_item_colon' => __( 'Parent Product Designer:', 'woocommerce' ),
	    'edit_item' 		=> __( 'Edit Product Designer', 'woocommerce' ),
	    'update_item' 		=> __( 'Update Product Designer', 'woocommerce' ),
	    'add_new_item' 		=> __( 'Add New Product Designer', 'woocommerce' ),
	    'new_item_name' 	=> __( 'New Product Designer Name', 'woocommerce' )
	);

	return $args;
}

// check sold individually by default
add_filter( 'woocommerce_is_sold_individually', 'default_no_quantities', 10, 2 );
function default_no_quantities( $individually, $product ){
    $individually = true;
    return $individually;
}

// disable lazy load
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

// disable meta categories
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


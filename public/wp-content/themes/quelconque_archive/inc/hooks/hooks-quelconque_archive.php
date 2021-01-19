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

// remove wysiwyg
add_action( 'init', 'remove_product_editor' );
function remove_product_editor() {
	remove_post_type_support( 'product', 'editor' );
}

// remove leto header
add_action('init', 'leto_child_remove_preloader');
function leto_child_remove_preloader() {
  remove_action( 'leto_inside_header', 'leto_main_navigation', 9 );
}

// add currencies into header
function leto_custom_navigation() {
	?>
		<nav id="site-navigation" class="main-navigation">
			<?php
				wp_nav_menu( array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				) );
			?>
		</nav><!-- #site-navigation -->	

		<div class="header-mobile-menu">
			<div class="header-mobile-menu__inner">
				<button class="toggle-mobile-menu">
					<span><?php esc_html_e( 'Toggle menu', 'leto' ); ?></span>
				</button>
			</div>
		</div><!-- /.header-mobile-menu -->		


		<?php $show_menu_additions = get_theme_mod( 'leto_show_menu_additions', 1 ); ?>
		<?php if ( $show_menu_additions ) : ?>
		<ul class="nav-link-right">
			<li class="nav-link-account">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<?php if ( is_user_logged_in() ) { ?>
						<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="Account"><span class="prefix"><?php esc_html_e( 'My account', 'leto' ); ?></span> <span class="suffix ion-person"></span></a>
					<?php } 
					else { ?>
						<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="Login"><span class="prefix"><?php esc_html_e( 'Login/Register', 'leto' ); ?></span> <span class="suffix ion-person"></span></a>
					<?php } ?>
				<?php else : ?>
					<a href="<?php echo esc_url( wp_login_url() ); ?>" title="Login"><span class="prefix"><?php esc_html_e( 'Login / Register', 'leto' ); ?></span> <span class="suffix ion-person"></span></a>
				<?php endif; ?>
			</li>

			<?php if ( class_exists( 'Woocommerce' ) ) : ?>

			<?php $cart_content = WC()->cart->cart_contents_count; ?>

			<li class="wmc-currency" data-currency="EUR">
				<a href="/?wmc-currency=EUR">EUR</a>
			</li>
			<li class="wmc-currency" data-currency="USD">
				<a href="/?wmc-currency=USD">USD</a>
			</li>
			<li class="wmc-currency" data-currency="GBP">
				<a href="/?wmc-currency=GBP">GBP</a>
			</li>
			<li class="nav-link-cart">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="header-cart-link">
					<i class="ion-bag"></i>
					<span class="screen-reader-text"><?php esc_html_e( 'Cart', 'leto' ); ?></span>
					<span class="cart-count">(<?php echo intval($cart_content); ?>)</span>
				</a>
				<div class="sub-menu cart-mini-wrapper">
					<div class="cart-mini-wrapper__inner">
					<?php woocommerce_mini_cart(); ?>
					</div>
				</div>
			</li>
			<?php endif; //end Woocommerce class_exists check ?>
			
			<?php
			$enable_search = get_theme_mod( 'leto_enable_search', 1 );
			if ( $enable_search ) : ?>
			<li class="nav-link-search">
				<a href="#" class="toggle-search-box">
					<i class="ion-ios-search"></i>
				</a>
			</li>
			<?php endif; ?>

		</ul>
		<?php endif; ?>

	<?php
}
add_action( 'leto_inside_header', 'leto_custom_navigation', 9 );
<?php

// display an 'Out of stock' label on product page
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

// // display filters on mobile menu
function remove_search_mobile_menu() {
	remove_action('leto_before_page', 'leto_mobile_menu');
}

add_action( 'wp_loaded', 'remove_search_mobile_menu');
add_action( 'leto_before_page', 'woocommerce_filters');
function woocommerce_filters() {
	$menuLocations = get_nav_menu_locations();
	$menuID = $menuLocations['mobile'];
	$mobile_menu = wp_get_nav_menu_items($menuID);

	$html = '<div class="mobile-menu">
				<nav class="mobile-menu__navigation">
				<ul>';

	foreach ($mobile_menu as $navItem) {
		$html .= '<li><a href="'.$navItem->url.'" title="'.$navItem->title.'">'.$navItem->title.'</a></li>';
	}

	$html .= '</ul>
			</nav>
			</div>';

    echo $html;
}

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

// manage stock to 1 by default
add_action( 'admin_footer', 'new_product_stock_default_setting' );
function new_product_stock_default_setting() {
    global $pagenow, $post_type;

    // Targeting new product page (admin)
    if( $pagenow === 'post-new.php' && $post_type === 'product' ) :
    ?>
    <script>
    jQuery(function($){
        var a = '#inventory_product_data input#';

        // Set Manage Stock and trigger event to show other related fields
        $(a+'_manage_stock').prop('checked', true).change();
        $(a+'_stock').val('1'); // Set Stock quantity to "1"
        $(a+'_low_stock_amount').val('0'); // Set Low stock threshold to "0"
    });
    </script>
    <?php
    endif;
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

// enable upload for webp image files
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

// dequeue cf7 enquiry stylesheet
function dequeue_plugin_style() {
    wp_dequeue_style( 'wqoecf-front-style.css' );
	wp_dequeue_script( 'wqoecf-front-script' );
}
add_action( 'wp_enqueue_scripts', 'dequeue_plugin_style', 100 );

// enable preview / thumbnail for webp image files
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);

/*
// add currencies into header
add_action( 'leto_inside_header', 'leto_custom_navigation', 9 );
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
*/

// remove add to cart button for every product
add_action( 'init', 'prfx_remove_add_to_cart_button');
function prfx_remove_add_to_cart_button() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10); // catalog page
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30); // single product page
}

// remove price from shop page
add_filter( 'woocommerce_after_shop_loop_item_title', 'remove_woocommerce_loop_price', 2 );
function remove_woocommerce_loop_price() {
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}
// remove price from product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );

// prevent products from being purchased
add_filter('woocommerce_is_purchasable', 'prfx_is_product_purchasbale');
function prfx_is_product_purchasbale($purchasable) {
    $purchasable = false;
    return $purchasable;
}

// add sidebar for mobile
register_sidebar( array(
	'name'          => esc_html__( 'Sidebar mobile', 'leto' ),
	'id'            => 'sidebar-2',
	'description'   => esc_html__( 'Add widgets here.', 'leto' ),
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h3 class="widget-title">',
	'after_title'   => '</h3>',
) );

// image on front page hero
function frontpage_hero() {
	global $is_safari;

	if ( !is_front_page() ) {
		return;
	}

	echo '<div class="hero-area">';
	if (wp_is_mobile()) {
		echo '<img src="' . get_stylesheet_directory_uri().'/assets/img/collage.jpg">';
	} else {
		if ($is_safari) {
			echo '<img src="' . get_stylesheet_directory_uri().'/assets/img/collages.jpg">';
		} else {
			echo '<img src="' . get_stylesheet_directory_uri().'/assets/img/collages.webp">';
		}
	}
	echo '</div>';
}

function leto_hero_slider_child() {
	remove_action('leto_after_header', 'leto_hero_slider');
	add_action('leto_after_header', 'frontpage_hero');
}
add_action('wp_loaded', 'leto_hero_slider_child');

// change logo on login page
function wpm_login_style() { ?>
    <style type="text/css">
		body.login {
			background: white;
		}
        #login h1 a, .login h1 a {
            background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg");
        }
		
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'wpm_login_style' );

// hide menu items
function my_remove_menu_pages() {
  global $user_ID;

  if ( $user_ID != 1 ) { //your user id

   remove_menu_page('edit.php'); // Posts
   remove_menu_page('upload.php'); // Media
   remove_menu_page('link-manager.php'); // Links
   remove_menu_page('edit-comments.php'); // Comments
   remove_menu_page('edit.php?post_type=page'); // Pages
   remove_menu_page('plugins.php'); // Plugins
   remove_menu_page('themes.php'); // Appearance
   remove_menu_page('users.php'); // Users
   remove_menu_page('tools.php'); // Tools
   remove_menu_page('options-general.php'); // Settings
   remove_menu_page('edit.php'); // Posts
   remove_menu_page('upload.php'); // Media
   remove_menu_page('woocommerce-marketing'); // Marketing
   remove_menu_page('wc-admin&path=/analytics/overview'); // Analytics
  }
}
add_action( 'admin_init', 'my_remove_menu_pages' );

add_action("wp_footer","add_ask_for_price_form");
function add_ask_for_price_form()
{
	?>
	<div class="wqoecf-pop-up-box">
		<button class="wqoecf_close"><?php echo dh_include_svg_from_uri(get_theme_file_path().'/assets/img/cross.svg'); ?></button>
		<div>
			<!-- local id -->
			<!-- <?php echo do_shortcode('[contact-form-7 id="239" title="Ask for price"]'); ?> -->
			<?php echo do_shortcode('[contact-form-7 id="34" title="Ask for price"]'); ?>
		</div>
	</div>

	<?php
}

// add GTAG script
function prefix_footer_code() {
	?>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-82MY1QFFMT"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-82MY1QFFMT');
		</script>
	<?php
}
add_action( 'wp_footer', 'prefix_footer_code' );
<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Leto
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside data-scroll data-scroll-sticky data-scroll-target=".row" id="secondary" data-scroll-offset="-80" class="widget-area primary-sidebar col-md-3">
	<?php
		if (wp_is_mobile()) {
			dynamic_sidebar( 'sidebar-2' );
		} else {
			dynamic_sidebar( 'sidebar-1' );
		}
	?>
</aside><!-- #secondary -->

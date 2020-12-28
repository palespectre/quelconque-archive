<?php

// stock message
add_filter('woocommerce_stock_html', 'change_stock_message', 10, 2);
function change_stock_message($message, $stock_status) {
    if ($stock_status == "Out of stock") {
        $message = '<p class="stock out-of-stock">Sold</p>';    
    }
    return $message;
}

// display an 'Out of Stock' label on archive pages
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_stock', 10 );
function woocommerce_template_loop_stock() {
    global $product;
    if ($product->stock_status === 'outofstock') {
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
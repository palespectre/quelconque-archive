<?php

// hide admin bar
add_filter( 'show_admin_bar', '__return_false' );
// disable loading of stylesheets and scripts from Contact Form 7 plugin
// add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );
// remove Get Shortlink
add_filter( 'pre_get_shortlink', '__return_empty_string' );
// Disable Canonical meta from Yoast SEO Plugin
add_filter( 'wpseo_canonical', '__return_false' );

remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

// Remove default Sitemap

  // if(is_plugin_active('wp-seopress')){

  //   add_filter( 'wp_sitemaps_enabled', '__return_false' );
  //   add_action( 'init', function() {
  //     remove_action( 'init', 'wp_sitemaps_get_server' );
  //   }, 5 );

  // }


// -----------------------------------------------------------------------------

/**
 * Disable emojicons.
 * @see http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
if ( ! is_admin() ) {
  add_action( 'init', 'disable_wp_emojicons' );
}

/**
 * Remove unnecessary metas from <head>.
 */
function remove_some_metas() {

    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'rel_canonical' );
}

add_action( 'after_setup_theme', 'remove_some_metas' );

// Suppression des tailles d'image par défaut
add_action( 'after_setup_theme', 'remove_default_image_sizes' );    
function remove_default_image_sizes(){
  
  add_filter('image_size_names_choose', 'array_diff_image_sizes', 11, 1);
  add_filter('intermediate_image_sizes_advanced', 'array_diff_image_sizes', 15);
  add_filter('intermediate_image_sizes', 'array_diff_image_sizes', 15);
}

  function array_diff_image_sizes($sizes) {
      $sizes = array_diff($sizes, array('medium', 'large','medium_large'));
      return $sizes;
  }

//Suppression des widgets du DashBoard
function remove_dashboard_widgets() {
  global $wp_meta_boxes;

  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
 
} 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

/* Désactivation Pingbacks internes */
function no_self_ping( &$links ) {
 $home = get_option( 'home' );
 foreach ( $links as $l => $link )
 if ( 0 === strpos( $link, $home ) )
 unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );
/* Fin Désactivation Pingbacks internes */

/**
 *  Désactiver l'API REST pour les utilisateurs non connectés
 */
/*
add_filter('rest_authentication_errors', 'secure_api');
function secure_api( $result ) {
    var_dump($result);
    if ( ! empty( $result ) ) {
        return $result;
    }
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
    }
    return $result;
  }

/**
 *  Désactiver l'API REST pour toutes les routes sauf certaines exclusions
 */
add_filter( 'rest_endpoints', function( $endpoints ){

  if ( ! is_user_logged_in() ) {

    $prefix = 'contact-form-7|wc-bookings';
   
    foreach ( $endpoints as $endpoint => $details ) {
      
      if (!preg_match('/^\/'.$prefix.'\//i', $endpoint) ) {
        unset( $endpoints[$endpoint] );
      }
    }
  }
  return $endpoints;

});


/**
 *  Désactiver XML RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );

/**
 * Nettoyage des noms de fichiers avec accents
 */
function wpc_sanitize_french_chars($filename) {
  
  /* Force the file name in UTF-8 (encoding Windows / OS X / Linux) */
  $filename = mb_convert_encoding($filename, "UTF-8");

  $char_not_clean = array('/À/','/Á/','/Â/','/Ã/','/Ä/','/Å/','/Ç/','/È/','/É/','/Ê/','/Ë/','/Ì/','/Í/','/Î/','/Ï/','/Ò/','/Ó/','/Ô/','/Õ/','/Ö/','/Ù/','/Ú/','/Û/','/Ü/','/Ý/','/à/','/á/','/â/','/ã/','/ä/','/å/','/ç/','/è/','/é/','/ê/','/ë/','/ì/','/í/','/î/','/ï/','/ð/','/ò/','/ó/','/ô/','/õ/','/ö/','/ù/','/ú/','/û/','/ü/','/ý/','/ÿ/', '/©/');
  $clean = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','u','u','u','u','y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','copy');

  $friendly_filename = preg_replace($char_not_clean, $clean, $filename);


  /* After replacement, we destroy the last residues */
  $friendly_filename = utf8_decode($friendly_filename);
  $friendly_filename = preg_replace('/\?/', '', $friendly_filename);


  /* Lowercase */
  $friendly_filename = strtolower($friendly_filename);

  return $friendly_filename;
}
add_filter('sanitize_file_name', 'wpc_sanitize_french_chars', 10);
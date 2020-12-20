<?php

if(MODE_DEV){
  add_filter( 'style_loader_src', 'force_ressource_refresh',10, 2 );
  add_filter( 'script_loader_src', 'force_ressource_refresh',10, 2 );
}

function force_ressource_refresh($src, $handle){

  $parsed = parse_url($src);

 !array_key_exists('query', $parsed) ? $parsed['query'] = null : null;

  $parsed['query'] = !empty($parsed['query']) ? $parsed['query'].'&t='.time() : 't='.time();

  return unparse_url($parsed);
}

function unparse_url($parsed_url) { 
  $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : ''; 
  $host     = isset($parsed_url['host']) ? $parsed_url['host'] : ''; 
  $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : ''; 
  $user     = isset($parsed_url['user']) ? $parsed_url['user'] : ''; 
  $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : ''; 
  $pass     = ($user || $pass) ? "$pass@" : ''; 
  $path     = isset($parsed_url['path']) ? $parsed_url['path'] : ''; 
  $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : ''; 
  $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : ''; 
  return "$scheme$user$pass$host$port$path$query$fragment"; 
} 
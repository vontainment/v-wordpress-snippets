<?php

/**
 * Vontainment Starter functions and definitions
 * @package WordPress
 * @subpackage vontmnt
 * @since Vontainment Starter 1.0
 */

function vontmnt_support()
{
  // Add support for block styles.
  add_theme_support('wp-block-styles');

  // Enqueue editor styles.
  add_editor_style('style.css');

  //Disabling the default block patterns.
  //remove_theme_support('core-block-patterns');
}
add_action('after_setup_theme', 'vontmnt_support');

function vontmnt_styles()
{
  wp_register_style('vontmnt-style', get_template_directory_uri() . '/style.css');

  // Enqueue theme stylesheet.
  wp_enqueue_style('vontmnt-style');
}
add_action('wp_enqueue_scripts', 'vontmnt_styles');

//Remove Inline Styles
add_filter('styles_inline_size_limit', '__return_zero');

//Load Seperate Block Styles
add_filter('should_load_separate_core_block_assets', '__return_true');

//Remove Global Styles and SVG Filters from WP 5.9.1 - 2022-02-27
function remove_global_styles_and_svg_filters()
  {
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
  }
add_action('init', 'remove_global_styles_and_svg_filters');

//Dequeue Unused Css
function dequeue_unused_css() {
  wp_dequeue_style('wp-webfonts');
  wp_deregister_style('wp-webfonts');
  wp_dequeue_style('wp-block-template-part');
  wp_deregister_style('wp-block-template-part');
  wp_dequeue_style('wp-block-site-logo');
  wp_deregister_style('wp-block-site-logo');
}
add_action('wp_enqueue_scripts', 'dequeue_unused_css', 330);

add_filter('wp_headers', 'wpse167128_nocache');
function wpse167128_nocache($headers)
{
  unset($headers['Cache-Control']);
  return $headers;
}

//P Dangit Filter
remove_filter('the_title', 'capital_P_dangit', 11);
remove_filter('wp_title', 'capital_P_dangit', 11);
remove_filter('the_content', 'capital_P_dangit', 11);
remove_filter('comment_text', 'capital_P_dangit', 31);

//Remove <p> on <img>
function von_no_ptags_around_img($content)
{
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'von_no_ptags_around_img');

// No query stings
function remove_query_strings()
{
  if (!is_admin()) {
    add_filter('script_loader_src', 'remove_query_strings_split', 15);
    add_filter('style_loader_src', 'remove_query_strings_split', 15);
  }
}

function remove_query_strings_split($src)
{
  $output = preg_split("/(&ver|\?ver)/", $src);
  return $output[0];
}
add_action('init', 'remove_query_strings');

//sanitize-file-name
add_filter( 'sanitize_file_name', 'remove_accents' );

//user sessions
add_filter('auth_cookie_expiration', 'my_expiration_filter', 99, 3);
function my_expiration_filter($seconds, $user_id, $remember){

//if "remember me" is checked;
if ( $remember ) {
//WP defaults to 2 weeks;
$expiration = 30*24*60*60; //UPDATE HERE;
} else {
//WP defaults to 48 hrs/2 days;
 $expiration = 2*24*60*60; //UPDATE HERE;
 }

 //http://en.wikipedia.org/wiki/Year_2038_problem
 if ( PHP_INT_MAX - time() < $expiration ) {
 //Fix to a little bit earlier!
 $expiration = PHP_INT_MAX - time() - 5;
 }

 return $expiration;
 }

foreach (glob(get_template_directory() . "/inc/*.php") as $file) {
  require $file;
}
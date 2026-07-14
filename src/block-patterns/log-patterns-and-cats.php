<?php

/******************************************************************************
 * 
 * List registered patterns and pattern categories
 *
 * ***NOTE*** Needs PHP 7+
 * 
 ******************************************************************************/

/**
 * Log registered patterns (doesn't log user-created patterns)
 */
add_filter('wp_loaded', 'snt_list_block_patterns');

function snt_list_block_patterns() {
  // Don't let this code break versions of WP < 5.5
  if (!class_exists('WP_Block_Patterns_Registry')) {
    return;
  }

  $pattern_array = WP_Block_Patterns_Registry::get_instance()->get_all_registered();

  $pattern_list = [];

  foreach ($pattern_array as $pattern) {
    $pattern_list[] = $pattern['name'];
  }

  $pattern_cats_array = WP_Block_Pattern_Categories_Registry::get_instance()->get_all_registered();

  $pattern_cats_list = [];

  foreach ($pattern_cats_array as $cat) {
    $pattern_cats_list[] = $cat['name'];
  }

  snt_print_patterns_to_console($pattern_list, "Pattern List");
}

/**
 * Log registered pattern categories (doesn't log user-created wp_pattern_category terms)
 */

add_filter('wp_loaded', 'snt_list_block_categories');

function snt_list_block_categories() {
  // Don't let this code break versions of WP < 5.5
  if (!class_exists('WP_Block_Patterns_Registry')) {
    return;
  }

  $pattern_cats_array = WP_Block_Pattern_Categories_Registry::get_instance()->get_all_registered();

  $pattern_cats_list = [];

  foreach ($pattern_cats_array as $cat) {
    $pattern_cats_list[] = $cat['name'];
  }

  snt_print_patterns_to_console($pattern_cats_list, "Pattern Cats List");
}

add_action('init', 'snt_list_user_created_pattern_category_terms');


/**
 * Log user created wp_pattern_category terms
 */
function snt_list_user_created_pattern_category_terms() {
  // Fetch all terms from the user pattern category taxonomy
  $use_created_pattern_categories = get_terms(array(
    'taxonomy'   => 'wp_pattern_category',
    'hide_empty' => false, // Show categories even if they have no patterns assigned
  ));

  snt_print_patterns_to_console($use_created_pattern_categories, "Use-created Pattern Cat Terms");
}

/**
 * Log a filter parameters to the browser console.
 * 
 * ***NOTE*** This function needs PHP 7+.
 * 
 * @param array $list A list of registered patterns or pattern categories.
 * @param string $list_name The list name. 
 */
function snt_print_patterns_to_console($list, $list_name) {

  $snt_print_to_console = function () use ($list, $list_name) {

    $string =  print_r($list, true);
    echo '<script>';
    echo "console.log( '*****$list_name*****' );";
    echo 'console.log( `' . addslashes($string) . '` );';
    echo '</script>';
  };

  add_action('wp_print_footer_scripts', $snt_print_to_console);
  add_action('admin_footer', $snt_print_to_console);
}

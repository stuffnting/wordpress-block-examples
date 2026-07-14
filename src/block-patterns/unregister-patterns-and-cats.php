<?php

/******************************************************************************
 * 
 * Unregister patterns and pattern categories
 * 
 ******************************************************************************/

/**
 * Remove all remote patterns
 */

add_filter('should_load_remote_block_patterns', '__return_false');

/**
 * Remove all default patterns
 */

add_action('after_setup_theme', 'snt_remove_all_patterns');

function snt_remove_all_patterns() {
  remove_theme_support('core-block-patterns');
}


/**
 * Remove individual patterns
 */
//add_action('init', 'snt_unregister_block_patterns_individual');

function snt_unregister_block_patterns_individual() {

  if (!function_exists('unregister_block_pattern')) {
    return;
  }

  $patterns_instance = WP_Block_Patterns_Registry::get_instance();

  if ($patterns_instance->is_registered('snt/image-and-text')) {
    unregister_block_pattern('snt/image-and-text');
  }
}

/**
 * Unregister patterns in bulk.
 * 
 * This example unregisters all the patterns registered by the theme and child-theme
 */

add_action('init', 'snt_unregister_block_patterns_bulk', 100);

function snt_unregister_block_patterns_bulk() {
  $parent_slug = get_template();
  $child_slug  = get_stylesheet();

  $patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered();

  if (! empty($patterns)) {
    foreach ($patterns as $pattern) {
      $name = $pattern['name'];

      if (
        strpos($name, $parent_slug . '/') === 0 ||
        strpos($name, $child_slug . '/') === 0 ||
        strpos($name, 'theme/') === 0
      ) {
        unregister_block_pattern($name);
      }
    }
  }
}

/**
 * Unregister pattern categories.
 * 
 * This function will unregister the category and if it has ended up as a 
 * wp_pattern_category taxonomy term via a user-created pattern, remove the term.
 * 
 * `text` is a core category and `my-nice-category` does not exist (but fails gracefully)
 */

add_action('init', 'snt_unregister_block_patterns_categories');

function snt_unregister_block_patterns_categories() {

  $cat_slugs = ['text', 'my-nice-category'];

  foreach ($cat_slugs as $slug) {
    if (function_exists('unregister_block_pattern_category')) {
      unregister_block_pattern_category($slug);
    }

    $term = get_term_by('slug', $slug, 'wp_pattern_category');

    if ($term && ! is_wp_error($term)) {
      wp_delete_term($term->term_id, 'wp_pattern_category');
    }
  }
}

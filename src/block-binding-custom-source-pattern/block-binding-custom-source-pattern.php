<?php

/**
 * This example demonstrates how to register a custom block binding source, and then use that source in a block pattern.
 */

/**
 * Register the block a dummy block to provide a JS entry point.
 */
add_action('init', 'snt_register_block_binding_custom_source_pattern');

function snt_register_block_binding_custom_source_pattern() {
  register_block_type(__DIR__);
}


/****************************************************************************
 * 
 * Register the script file for the editor.
 * 
 * Since this example registers a dummy block, the editor script is 
 * automatically enqueued, and there is no need to do it here.
 * 
 ****************************************************************************/

//add_action('enqueue_block_editor_assets', 'snt_block_binding_custom_source');

function snt_block_binding_custom_source_pattern() {
  wp_enqueue_script(
    'snt-block-binding-custom-source-pattern',
    plugin_dir_url(__FILE__) . 'block-binding-custom-source-pattern.js',
    ['wp-blocks', 'wp-i18n'],
    filemtime(plugin_dir_path(__FILE__) . 'block-binding-custom-source-pattern.js')
  );
}

/****************************************************************************
 * 
 * Register the block binding source.
 * 
 ****************************************************************************/

add_action('init', 'snt_register_block_binding_custom_source_pattern_binding_sources');

function snt_register_block_binding_custom_source_pattern_binding_sources() {
  register_block_bindings_source('snt/block-binding-custom-source-pattern', [
    'label'              => __('Block Binding Custom Source With Pattern', 'snt'),
    'get_value_callback' => 'snt_block_binding_custom_source_pattern_callback',
    'uses_context'       => ['postId', 'postType'],
  ]);
}

function snt_block_binding_custom_source_pattern_callback($source_args, $block_instance, $attribute_name) {
  if (! isset($source_args['key'])) {
    return null;
  }

  $post_id = $block_instance->context['postId'] ?? get_the_ID();

  /**
   * Note, each binding `key` in the editor HTML has been set to the correct value 
   * to use with getEditedPostAttribute() in the JS script. That is: `title`, `excerpt` and `permalink`.
   */
  if ('title' === $source_args['key']) {
    return get_post_field('post_title', $post_id);
  } elseif ('excerpt' === $source_args['key']) {
    return get_post_field('post_excerpt', $post_id);
  } elseif ('permalink' === $source_args['key']) {
    return get_permalink($post_id);
  }

  return null;
}

/****************************************************************************
 * 
 * Register the black pattern that uses the block binding.
 * 
 * Note, each binding `key` in the editor HTML has been set to the correct value
 * to use with getEditedPostAttribute() in the JS script. That is: `title`, 
 * `excerpt` and `permalink`.
 * 
 ****************************************************************************/

add_action('init', 'snt_block_binding_custom_source_pattern_register_patterns');

function snt_block_binding_custom_source_pattern_register_patterns() {
  register_block_pattern('snt/block-binding-custom-source-pattern', array(
    'title'       => __('Block Binding Custom Source Pattern', 'snt'),
    'description' => __('For testing block binding with custom sources'),
    'categories'  => array('posts'),
    'keywords'    => array('block binding'),
    'blockTypes'  => array('core/heading', 'core/paragraph', 'core/button'),
    'postType'    => array('posts'),
    'content'     => '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"placeholder":"Add post title","metadata":{"bindings":{"content":{"source":"snt/block-binding-custom-source-pattern","args":{"key":"title"}}}}} -->
<h2 class="wp-block-heading"></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"Add post excerpt","metadata":{"bindings":{"content":{"source":"snt/block-binding-custom-source-pattern","args":{"key":"excerpt"}}}}} -->
<p></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"metadata":{"bindings":{"url":{"source":"snt/block-binding-custom-source-pattern","args":{"key":"permalink"}}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Read post →</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->'
  ));
}

<?php

/**
 * This example demonstrates how to register a custom block binding source, and then use that source in a block pattern.
 */

/**
 * Register the block a dummy block to provide a JS entry point.
 */
add_action('init', 'snt_register_block_binding_custom_source_ui');

function snt_register_block_binding_custom_source_ui() {
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

function snt_block_binding_custom_source_ui() {
  wp_enqueue_script(
    'snt-block-binding-custom-source-ui',
    plugin_dir_url(__FILE__) . 'block-binding-custom-source-ui.js',
    ['wp-blocks', 'wp-i18n'],
    filemtime(plugin_dir_path(__FILE__) . 'block-binding-custom-source-ui.js')
  );
}

/****************************************************************************
 * 
 * Register the block binding sources and callbacks.
 * 
 ****************************************************************************/

add_action('init', 'snt_register_block_binding_custom_source_ui_binding_sources');

function snt_register_block_binding_custom_source_ui_binding_sources() {
  /**
   * Image block
   */
  register_block_bindings_source('snt/block-binding-custom-source-ui-image', [
    'label'              => __('Block Binding Custom Source With UI Controls Image', 'snt'),
    'get_value_callback' => 'snt_block_binding_custom_source_ui_image_callback',
    'uses_context'       => ['postId', 'postType'],
  ]);
  /**
   * Button block
   */
  register_block_bindings_source('snt/block-binding-custom-source-ui-button', [
    'label'              => __('Block Binding Custom Source With UI Controls Button', 'snt'),
    'get_value_callback' => 'snt_block_binding_custom_source_ui_button_callback',
    'uses_context'       => ['postId', 'postType'],
  ]);
}

/**
 * Image block callback
 */
function snt_block_binding_custom_source_ui_image_callback(array $source_args, $block_instance, string $attribute_name) {

  $block_name = '';

  if (is_object($block_instance) && isset($block_instance->name)) {
    $block_name = (string) $block_instance->name;
  }

  if ('core/image' !== $block_name) {
    return null;
  }

  if (
    'url' === $attribute_name
    && isset($source_args['key'])
    && 'image_url' === $source_args['key']
  ) {
    return 'https://pd.w.org/2023/04/893642d3da2481166.65757956.jpg';
  }

  if (
    'caption' === $attribute_name
    && isset($source_args['key'])
    && 'image_caption' === $source_args['key']
  ) {
    return __('Photo by: Carole', 'snt');
  }

  if (
    'alt' === $attribute_name
    && isset($source_args['key'])
    && 'alt' === $source_args['key']
  ) {
    return __('A small black and brown dog is swimming in a pool with clear turquoise water.', 'snt');
  }

  return null;
}

/**
 * Filter out the core/image attributes that don't have bindings set
 */
add_filter('block_bindings_supported_attributes_core/image', 'snt_block_binding_custom_source_ui_image_attr_filter');

function snt_block_binding_custom_source_ui_image_attr_filter(array $attributes) {

  $remove_binding_support = ['id', 'title'];
  $filtered_attributes = array_diff($attributes, $remove_binding_support);

  // Reset array keys so they start from 0
  $filtered_attributes = array_values($filtered_attributes);

  return $filtered_attributes;
}

/**
 * Button block callback
 */
function snt_block_binding_custom_source_ui_button_callback(array $source_args, $block_instance, string $attribute_name) {

  $block_name = '';

  if (is_object($block_instance) && isset($block_instance->name)) {
    $block_name = (string) $block_instance->name;
  }

  if ('core/button' !== $block_name) {
    return null;
  }

  if (
    'url' === $attribute_name
    && isset($source_args['key'])
    && 'button_url' === $source_args['key']
  ) {
    return 'https://wordpress.org/photos/?s=dogs';
  }

  if (
    'text' === $attribute_name
    && isset($source_args['key'])
    && 'button_text' === $source_args['key']
  ) {
    return __('See more photos', 'snt');
  }
  return null;
}

/**
 * Filter out the core/image attributes that don't have bindings set
 */
add_filter('block_bindings_supported_attributes_core/button', 'snt_block_binding_custom_source_ui_button_attr_filter');

function snt_block_binding_custom_source_ui_button_attr_filter(array $attributes) {

  $remove_binding_support = ['rel', 'linkTarget'];
  $filtered_attributes = array_diff($attributes, $remove_binding_support);

  // Reset array keys so they start from 0
  $filtered_attributes = array_values($filtered_attributes);

  return $filtered_attributes;
}

<?php

add_action('init', 'snt_register_block_binding_meta_box');

function snt_register_block_binding_meta_box() {
  register_block_type(__DIR__);
}

/******************************************************************************
 * 
 * Register the meta field
 * 
 *****************************************************************************/

/**
 * Fetch the meta key from the meta-simple.metafield.json file.
 */
function snt_get_block_binding_meta_field() {
  if (file_exists(__DIR__ . '/block.json')) {

    $block_json = file_get_contents(__DIR__ . '/block.json');

    $json_array = $block_json
      ? json_decode($block_json, true)
      : false;

    $meta_field = $json_array["attributes"]["snt"]["metaField"] ?? null;
  } else {
    $meta_field = null;
    error_log("ERROR: block.json file not found. Logged from line" . __LINE__ . " in " . __FILE__);
  }

  return $meta_field;
}

/**
 * Register the meta field
 */
add_action('init', 'snt_register_block_binding_meta_box_field');

function snt_register_block_binding_meta_box_field() {
  $meta_field = snt_get_block_binding_meta_field();

  if ($meta_field) {
    register_meta(
      'post',
      $meta_field,
      array(
        'show_in_rest'       => true,
        'single'             => true,
        'type'               => 'string',
        'default'            => '',
        'label'              => 'SNT Block Binding Meta Box',
        'sanitize_callback'  => 'sanitize_textarea_field',
        'auth_callback'      => function () {
          return current_user_can('edit_posts');
        }
      )
    );
  } else {
    error_log("ERROR: Meta field key not found in block.json. Logged from line" . __LINE__ . " in " . __FILE__);
  }
}

<?php

add_action('init', 'snt_register_meta_richtext');

function snt_register_meta_richtext() {
  register_block_type(__DIR__);
}

/**
 * Get the meat field from block.json
 */

if (file_exists(__DIR__ . '/block.json')) {
  $jsonString = file_get_contents(__DIR__ . '/block.json');

  // Use JSON_THROW_ON_ERROR to catch syntax issues instantly
  try {
    $block_data = json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);

    // Null coalescing operator (??) prevents "Undefined index" notices
    $meta_field = $block_data['attributes']['sntMeta']['default'] ?? 'Not found';
  } catch (JsonException $e) {
    echo "Invalid JSON formatting: " . $e->getMessage();
  }
} else {
  $meta_field = '';
}

define('SNT_META_RICHTEXT_METAFIELD', $meta_field);

/**
 * Register the meta field
 */

register_post_meta(
  '', // Any post type
  SNT_META_RICHTEXT_METAFIELD,
  array(
    'show_in_rest'       => true,
    'type'               => 'string',
    'default'            => '',
    'single'             => true,
    'sanitize_callback'  => 'sanitize_textarea_field',
    'auth_callback'      => function () {
      return current_user_can('edit_posts');
    }
  )
);

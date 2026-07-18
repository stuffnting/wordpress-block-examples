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

define('SNT_META_BOXES_FIELD', $meta_field);

/**
 * Register the meta field
 */

register_post_meta(
  'post',
  SNT_META_BOXES_FIELD,
  array(
    'type'          => 'object',
    'single'        => true,
    'show_in_rest' => array(
      'schema' => array(
        'type'       => 'object',
        'properties' => array(
          'colour'  => array(
            'type' => 'string',
            'default' => ''
          ),
          'datetime' => array(
            'type' => 'string',
            'default' => ''
          ),
          'richtext' => array(
            'type' => 'string',
            'default' => ''
          ),
          'number' => array(
            'type' => 'integer',
            'default' => 0
          ),
          'radio' => array(
            'type' => 'string',
            'default' => ''
          ),
        ),
      ),
    ),
    'sanitize_callback' => 'snt_sanitize_meta_boxes_field',
    'auth_callback'   => function () {
      return current_user_can('edit_posts');
    }
  )
);

function snt_sanitize_meta_boxes_field($meta_value) {
  $defaults = array(
    'colour'   => '',
    'datetime' => '',
    'richtext' => '',
    'number' => 0,
    'radio' => '',
  );

  // Make sure we're working with an array, not garbage input.
  $meta_value = is_array($meta_value) ? $meta_value : array();
  $meta_value = wp_parse_args($meta_value, $defaults);

  return array(
    'colour'   => sanitize_text_field($meta_value['colour']),
    'datetime' => sanitize_text_field($meta_value['datetime']),
    'richtext' => wp_kses_post($meta_value['richtext']),
    'number' => (int) $meta_value['number'],
    'radio' => sanitize_text_field($meta_value['radio']),
  );
}

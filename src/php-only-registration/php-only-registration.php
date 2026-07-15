<?php

/**
 * Full list of args at https://developer.wordpress.org/reference/classes/wp_block_type/__construct/
 */

add_action('init', 'snt_php_only_registration');

function snt_php_only_registration() {
  register_block_type(
    'snt/block-only-registration',
    array(
      'api_version' => 3,
      'title' => __('SNT PHP Only Registration', 'snt'),
      'category' => 'snt-block-category',
      'icon' => 'lightbulb',
      'attributes' => array(
        'title'     => array(
          'label'     => __('Title', 'snt'),
          'type'      => 'string',
          'default'   => 'Pants',
        ),
        'count'   => array(
          'label'     => __('Count', 'snt'),
          'type'      => 'integer',
          'default'   => 5,
        ),
        'enabled' => array(
          'label'     => __('Enabled?', 'snt'),
          'type'      => 'boolean',
          'default'   => true,
        ),
        'size'    => array(
          'label'     => __('Size', 'snt'),
          'type'      => 'string',
          'enum'      => array('small', 'medium', 'large', 'x-large', 'xx-large'),
          'default'   => 'medium',
        ),
      ),
      'supports'        => array(
        'autoRegister'  => true, // Required
        'color'       => array(
          'background'  => true,
          'text' => true
        ),
      ),
      'render_callback' => 'snt_php_only_registration_cb',
    )
  );
};

function snt_php_only_registration_cb($attributes) {
  return sprintf(
    __('<div %s><p style="font-size: %s;">%s: %d items (%s)</p></div>', 'snt'),
    get_block_wrapper_attributes(),
    esc_attr($attributes['size']),
    esc_html($attributes['title']),
    $attributes['count'],
    $attributes['size']
  );
}

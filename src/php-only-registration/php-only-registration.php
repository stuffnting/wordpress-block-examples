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
      'category' => 'snt-custom-cat',
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
          'enum'      => array('small', 'medium', 'large'),
          'default'   => 'medium',
        ),
      ),

      'render_callback' => function ($attributes) {
        return sprintf(
          __('<p>%s: %d items (%s)</p>', 'snt'),
          esc_html($attributes['title']),
          $attributes['count'],
          $attributes['size']
        );
      },
      'supports'       => array(
        'autoRegister' => true,
      ),
    )
  );
}

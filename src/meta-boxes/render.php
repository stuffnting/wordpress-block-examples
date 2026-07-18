<?php

$post_id = $block->context['postId'];

// Either/Or
//$meta_data = get_post_meta($post_id, SNT_META_BOXES_FIELD, true);
$meta_data = get_post_meta($post_id, $attributes['sntMeta'], true);

$defaults = array(
  'colour'    => 'No Colour',
  'datetime'  => 'No DateTime',
  'richtext'  => 'No RichText',
  'number'    => 0,
  'radio'     => 'No Station Selected'
);

// Make sure we're working with an array, not garbage input.
$meta_value = is_array($meta_data) ? $meta_data : array();
$meta_value = wp_parse_args($meta_data, $defaults);

extract($meta_value);

printf(
  "<div %s>\n
    <p>Colour: %s</p>\n
    <p>DateTime: %s</p>\n
    <p>RichText: %s</p>\n
    <p>Number: %s</p>\n
    <p>Radio: %s</p>\n
  </div>",
  get_block_wrapper_attributes(),
  $colour,
  $datetime,
  $richtext,
  $number,
  $radio
);

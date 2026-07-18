<?php
global $post;
$meta_data_v1 = get_post_meta($post->ID, SNT_META_RICHTEXT_METAFIELD, true);
$meta_data_v2 = get_post_meta($post->ID, $attributes['sntMeta'], true);

printf(
  "<div %s>\n<p>%s</p>\n<p>%s</p></div>",
  get_block_wrapper_attributes(),
  $meta_data_v1,
  $meta_data_v2,
);

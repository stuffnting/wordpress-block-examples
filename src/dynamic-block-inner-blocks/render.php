<?php
$recent_posts = wp_get_recent_posts(array(
  'numberposts' => 5,
  'post_status' => 'publish',
));

if (count($recent_posts) === 0) {
  return 'No posts';
}

$out = '<h2>Dynamic with inner blocks</h2>';
$out .= '<ul>';

foreach ($recent_posts as $a_post) {
  $out .= sprintf(
    '<li><a href="%1$s">%2$s</a></li>',
    esc_url(get_permalink($a_post['ID'])),
    esc_html(get_the_title($a_post['ID']))
  );
}

$out .= '</ul>';

/**
 * Get the class, style and id attributes for the block currently being rendered.
 * In this case, the outer block.
 * @see {@link https://developer.wordpress.org/reference/functions/get_block_wrapper_attributes/}
 */
$wrapper_attributes = get_block_wrapper_attributes();

printf(
  '<div %1$s>%2$s %3$s %4$s</div>',
  $wrapper_attributes,
  $out,
  "\n",
  $content
);

<?php

$pages = new WP_Query(['post_type' => 'page', 'posts_per_page' => $attributes['pagesToShow']]);

if (! $pages->have_posts()) {
  return '';
}

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
  <h2>Recent Pages useServerSideRender</h2>
  <ul>
    <?php foreach ($pages->posts as $page) : ?>
      <li><?php echo esc_html(get_the_title($page)); ?></li>
    <?php endforeach ?>
  </ul>
</div>
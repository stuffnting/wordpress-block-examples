<?php

/**
 * This example demonstrates how to register a dynamic block using a render callback function, rather than a render.php file. 
 */

add_action('init', 'snt_register_dynamic_block_render_function');

function snt_register_dynamic_block_render_function() {
  register_block_type(__DIR__, array(
    'render_callback' => 'snt_dynamic_block_render_function_callback'
  ));
}

/**
 * Render callback for the dynamic block.
 * 
 * You can either use the output buffer, or create an HTML string containing the render markup.
 */
function snt_dynamic_block_render_function_callback($attributes, $content, $block) {
  $pages = new WP_Query(['post_type' => 'page', 'posts_per_page' => $attributes['pagesToShow']]);

  if (! $pages->have_posts()) {
    return '';
  }

  ob_start();
?>

  <div <?php echo get_block_wrapper_attributes(); ?>>
    <h2>Recent pages</h2>
    <ul>
      <?php foreach ($pages->posts as $page) : ?>
        <li><?php echo esc_html(get_the_title($page)); ?></li>
      <?php endforeach ?>
    </ul>
  </div>

<?php

  return ob_get_clean();
}

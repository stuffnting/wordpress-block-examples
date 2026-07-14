<?php

add_action('init', 'snt_register_block_patterns');

function snt_register_block_patterns() {

  if (!function_exists('register_block_pattern')) {
    return;
  }

  /**
   * Register a new block pattern category. 
   * If the category is empty it will not appear in the inserter.
   */
  register_block_pattern_category(
    'snt-patterns',
    ['label' => __('SNT Patterns Cat', 'snt')]
  );

  /**
   * Register a pattern
   * snt/image-and-text
   */
  $snt_image_and_text_content = '<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="https://www.stuffnting.com/wp-content/uploads/2017/08/D-R_test_DSC00322_sml.jpg" alt=""/></figure>
<!-- /wp:image -->

<!-- wp:paragraph -->
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->';

  register_block_pattern('snt/image-and-text', [
    'title' => __('Images and text in columns', 'snt'),
    'description' => __('My nice block pattern', 'snt'),
    'keywords' => ['pictures'],
    'categories' => ['snt-patterns'],
    'viewportWidth' => 840,
    'content' => $snt_image_and_text_content,
  ]);
}

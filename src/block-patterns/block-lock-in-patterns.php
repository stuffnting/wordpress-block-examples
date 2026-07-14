<?php

/**
 * core/paragraph blocks are not normally locked for removal from patterns, 
 * which by default have contentOnly editing.
 * 
 * This example registers a pattern where the block lock is used to lock the paragraphs.
 * 
 * The social media link items remain unlocked can can be removed, 
 * although the social media container cannot.
 */

add_action('init', 'snt_register_block_lock_in_patterns');

function snt_register_block_lock_in_patterns() {

  if (!function_exists('register_block_pattern')) {
    return;
  }

  $block_lock_in_patterns_content = '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading -->
<h2 class="wp-block-heading">A socials pattern</h2>
<!-- /wp:heading -->

<!-- wp:image {"id":2288,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="http://localhost:10013/wp-content/uploads/2026/07/Pan-and-Scan-Example.jpg" alt="" class="wp-image-2288"/></figure>
<!-- /wp:image --></div>

<!-- wp:paragraph {"lock":{"move":true,"remove":true}} -->
<p>These are some links to all my socials. Please click on them and like me, and subscribe me.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"lock":{"move":true,"remove":true}} -->
<p>This is a second paragraph to test the contentOnly exception.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"openInNewTab":true,"size":"has-huge-icon-size"} -->
<ul class="wp-block-social-links has-huge-icon-size"><!-- wp:social-link {"url":"#","service":"wordpress"} /-->

<!-- wp:social-link {"url":"#","service":"fivehundredpx"} /-->

<!-- wp:social-link {"url":"#","service":"amazon"} /-->

<!-- wp:social-link {"url":"#","service":"bluesky"} /-->

<!-- wp:social-link {"url":"#","service":"etsy"} /-->

<!-- wp:social-link {"url":"#","service":"dribbble"} /-->

<!-- wp:social-link {"url":"#","service":"bandcamp"} /--></ul>
<!-- /wp:social-links -->
<!-- /wp:group -->';

  register_block_pattern('snt/block-lock-in-patterns', [
    'title' => __('SNT Block Lock In Patterns', 'snt'),
    'description' => __('Test the block lock in patterns', 'snt'),
    'keywords' => ['pictures', 'social media'],
    'categories' => ['snt-patterns'],
    'viewportWidth' => 500,
    'content' => $block_lock_in_patterns_content,
  ]);
}

<?php

/**
 * Contextual pattern example.
 * 
 * Uses blockTypes to specify blocks for which the pattern should appear as a suggestion in 
 * the transforms available in the block's toolbar.
 */

add_action('init', 'snt_register_block_contextual_patterns');

function snt_register_block_contextual_patterns() {

  if (!function_exists('register_block_pattern')) {
    return;
  }

  register_block_pattern(
    'snt/heading-example',
    array(
      'title'         => __('Black heading with image contextual example', 'snt'),
      'categories'    => ['snt-patterns'],
      'blockTypes'    => ['core/heading'], // These are the block for which this pattern will be suggested
      'viewportWidth' => 500,
      'content'       => '<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
                      <figure class="wp-block-image size-large"><img src="https://s.w.org/images/core/5.8/nature-above-01.jpg" alt=""/></figure>
                      <!-- /wp:image -->
                      <!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"var(--wp--preset--color--white)"}}}},"backgroundColor":"black","textColor":"white"} -->
                      <h3 class="wp-block-heading has-white-color has-black-background-color has-text-color has-background">My most excellent heading</h3>
                      <!-- /wp:heading -->',
    )
  );

  $snt_image_and_text_contextual_content = '<!-- wp:group {"metadata":{"categories":["text"],"patternName":"myprefix/image-and-text","name":"Images and text in columns"},"align":"full"} -->
<div class="wp-block-group alignfull"><!-- wp:columns {"verticalAlignment":"top","align":"full"} -->
<div class="wp-block-columns alignfull are-vertically-aligned-top"><!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="https://www.stuffnting.com/wp-content/uploads/2017/08/D-R_test_DSC00280_sml.jpg" alt=""/><figcaption class="wp-element-caption">Caption number one</figcaption></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"is-style-default"} -->
<p class="is-style-default">One advanced diverted domestic sex repeated bringing you old. Possible procured her trifling laughter thoughts property she met way. Companions shy had solicitude favourable own. Which could saw guest man now heard but. Lasted my coming uneasy marked so should. Gravity letters it amongst herself dearest an windows by. Wooded ladies she basket season age her uneasy saw. Discourse unwilling am no described dejection incommode no listening of. Before nature his parish boy.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="https://www.stuffnting.com/wp-content/uploads/2017/08/D-R_test_DSC00280_sml.jpg" alt=""/><figcaption class="wp-element-caption">Caption number 3</figcaption></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"is-style-default"} -->
<p class="is-style-default">Folly words widow one downs few age every seven. If miss part by fact he park just shew. Discovered had get considered projection who favourable. Necessary up knowledge it tolerably. Unwilling departure education is be dashwoods or an. Use off agreeable law unwilling sir deficient curiosity instantly. Easy mind life fact with see has bore ten. Parish any chatty can elinor direct for former. Up as meant widow equal an share least.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"top"} -->
<div class="wp-block-column is-vertically-aligned-top"><!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"><img src="https://www.stuffnting.com/wp-content/uploads/2017/08/D-R_test_DSC00280_sml.jpg" alt=""/><figcaption class="wp-element-caption">Caption number three</figcaption></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"is-style-default"} -->
<p class="is-style-default">Village did removed enjoyed explain nor ham saw calling talking. Securing as informed declared or margaret. Joy horrible moreover man feelings own shy. Request norland neither mistake for yet. Between the for morning assured country believe. On even feet time have an no at. Relation so in confined smallest children unpacked delicate. Why sir end believe uncivil respect. Always get adieus nature day course for common. My little garret repair to desire he esteem.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->';

  register_block_pattern('snt/image-and-text-contextual', [
    'title' => __('Images and text in columns contextual example', 'snt'),
    'description' => __('My nice block pattern', 'snt'),
    'keywords' => ['columns', 'pictures'],
    'categories' => ['columns', 'snt-patterns'],
    'blockTypes' => ['core/paragraph', 'core/image', 'core/post-content'],
    'viewportWidth' => 840,
    'content' => $snt_image_and_text_contextual_content,
  ]);
}

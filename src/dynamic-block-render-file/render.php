<?

/**
 * Available variables:
 * 
 * $attributes (array)
 * $content (string)
 * $block (WP_Block object)
 *    $block->name – The block name (e.g., my-plugin/my-custom-block).
 *    $block->context – An array containing values passed down from parent blocks (like postId or postType).
 *    $block->parsed_block – The raw block structure array parsed by WordPress.
 */

$pages = new WP_Query(['post_type' => 'page', 'posts_per_page' => $attributes['pagesToShow']]);

if (! $pages->have_posts()) {
  return '';
}

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
  <h2>Recent pages</h2>
  <ul>
    <?php foreach ($pages->posts as $page) : ?>
      <li><?php echo esc_html(get_the_title($page)); ?></li>
    <?php endforeach ?>
  </ul>
</div>
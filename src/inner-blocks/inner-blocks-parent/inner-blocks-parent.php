<?

add_action('init', 'snt_inner_blocks_parent');

function snt_inner_blocks_parent() {

  if (! function_exists('register_block_type')) {
    // Gutenberg is not active.
    return;
  }

  register_block_type(__DIR__);
}

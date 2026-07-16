<?

add_action('init', 'snt_inner_blocks_child');

function snt_inner_blocks_child() {

  if (! function_exists('register_block_type')) {
    // Gutenberg is not active.
    return;
  }

  register_block_type(__DIR__);
}

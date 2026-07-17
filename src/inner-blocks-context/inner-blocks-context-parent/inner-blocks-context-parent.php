<?

add_action('init', 'snt_inner_blocks_context_parent');

function snt_inner_blocks_context_parent() {
  register_block_type(__DIR__);
}

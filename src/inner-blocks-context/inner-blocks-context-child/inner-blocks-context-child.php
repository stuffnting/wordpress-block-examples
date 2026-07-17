<?

add_action('init', 'snt_inner_blocks_context_child');

function snt_inner_blocks_context_child() {
  register_block_type(__DIR__);
}

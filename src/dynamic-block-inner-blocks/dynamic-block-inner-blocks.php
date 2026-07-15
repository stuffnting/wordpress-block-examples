<?php

/******************************************************************************
 * 
 * Register the block
 * 
 *****************************************************************************/

add_action('init', 'snt_register_dynamic_inner_blocks');

function snt_register_dynamic_inner_blocks() {
  register_block_type(__DIR__);
}

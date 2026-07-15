<?php

/******************************************************************************
 * 
 * Register the block
 * 
 *****************************************************************************/
add_action('init', 'snt_dynamic_block_inspector_controls_supports');

function snt_dynamic_block_inspector_controls_supports() {
  register_block_type(__DIR__);
}

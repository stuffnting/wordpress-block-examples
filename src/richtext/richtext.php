<?php

/******************************************************************************
 * 
 * Register the block
 * 
 *****************************************************************************/

add_action('init', 'snt_richtext');

function snt_richtext() {

  if (! function_exists('register_block_type')) {
    // Gutenberg is not active.
    return;
  }

  register_block_type(__DIR__);
}

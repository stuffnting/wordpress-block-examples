<?php

/**
 * This example demonstrates how to add a custom icon to a block.
 * 
 * Note that the icon defined in block.json is replaced by the icon defined in registerBlockType()
 */

add_action('init', 'snt_custom_icon');

function snt_custom_icon() {
  register_block_type(__DIR__);
}

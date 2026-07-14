<?php

/**
 * This example shows how to register a custom block collection for the "snt" namespace.
 * 
 * In order for @wordpress/scripts to include the JS file as an entry point, a dummy 
 * block is registered that does nothing, and is hidden from the inserter.
 */

add_action('init', 'snt_register_block_collection');

function snt_register_block_collection() {
  register_block_type(__DIR__);
}

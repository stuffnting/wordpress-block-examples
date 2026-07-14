<?php

/**
 * This example demonstrates how to register a dynamic block using a render.php file, rather than a callback function.
 */

add_action('init', 'snt_register_dynamic_block_render_file');

function snt_register_dynamic_block_render_file() {
  register_block_type(__DIR__);
}

<?php

/**
 * This example demonstrates how to register a dynamic block using a render.php file, rather than a callback function.
 */

add_action('init', 'snt_server_side_render');

function snt_server_side_render() {
  register_block_type(__DIR__);
}

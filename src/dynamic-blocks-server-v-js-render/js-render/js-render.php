<?php

/**
 * This example demonstrates how to register a dynamic block using a render.php file, rather than a callback function.
 */

add_action('init', 'snt_js_render');

function snt_js_render() {
  register_block_type(__DIR__);
}

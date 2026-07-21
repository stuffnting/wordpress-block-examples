<?php

add_action('init', 'snt_register_i11y_api_simple');

function snt_register_i11y_api_simple() {
  register_block_type(__DIR__);
}

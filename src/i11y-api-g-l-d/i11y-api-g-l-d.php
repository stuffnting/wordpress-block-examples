<?php

/**
 * Interactivity API with g-l-d = Global State, Local Context and Derived State 
 */

function snt_register_i11y_api_g_l_d_block() {
  register_block_type(__DIR__);
}
add_action('init', 'snt_register_i11y_api_g_l_d_block');

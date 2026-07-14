<?php


add_action('init', 'snt_register_block_json_assets');

function snt_register_block_json_assets() {
  register_block_type(__DIR__);
}

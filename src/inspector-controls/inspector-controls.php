<?php

add_action('init', 'snt_register_inspector_controls');

function snt_register_inspector_controls() {
  register_block_type(__DIR__);
}

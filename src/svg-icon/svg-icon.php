<?php

add_action('init', 'snt_register_svg_icon');

function snt_register_svg_icon() {
  register_block_type(__DIR__);
}

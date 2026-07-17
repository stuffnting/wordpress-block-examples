<?php

$my_number = array_key_exists('snt/myNumber', $block->context)
  ?  $block->context['snt/myNumber']
  : "No number";

$wrapper_attributes = get_block_wrapper_attributes();

printf(
  '<div %1$s><p>My Number Is (from child\'s render_callback): %2$s</p><p> %3$s</p></div>',
  $wrapper_attributes,
  $my_number,
  $content
);

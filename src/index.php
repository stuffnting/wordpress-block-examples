<?php

/**
 * Plugin Name: New Block Examples
 * Update URI: false
 */

add_filter("block_categories_all", "snt_register_block_categories");

function snt_register_block_categories($block_categories) {
  $custom_categories = [
    [
      "slug" => "snt-block-category",
      "title" => "SNT Blocks"
    ]
  ];

  foreach ($block_categories as $index => $category) {
    if ($category['slug'] === 'text') {
      array_splice(
        $block_categories,
        $index + 1,
        0,
        $custom_categories
      );

      break;
    }
  }

  return $block_categories;
}

if (file_exists(__DIR__ . '/build-list.json')) {
  $build_list_json = file_get_contents(__DIR__ . '/build-list.json', true);
  $build_list = json_decode($build_list_json, true);

  snt_process_require_from_json($build_list);
} else {
  error_log("ERROR: Can't find build-list.json file. Logged from line" . __LINE__ . " in " . __FILE__);
}

function snt_process_require_from_json($build_list) {

  if (!is_array($build_list)) {
    return;
  }

  // Ignore these keys in the JSON data
  $ignore_keys = ['$schema', '_NOTE'];

  foreach ($build_list as $key => $value) {

    if (in_array($key, $ignore_keys)) {
      continue;
    }

    // Build the file path to the block's PHP file
    $file = __DIR__ . "/$key/$key.php";

    // If 'include' is true, add a require statement
    if ($value['include'] === true && file_exists($file)) {
      require_once($file);
    }
  }
}

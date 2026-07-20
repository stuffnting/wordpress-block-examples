<?php

add_action('init', 'snt_register_inspector_controls');

function snt_register_inspector_controls() {
  register_block_type(__DIR__);
}

/******************************************************************************
 * 
 * Filters
 * 
 *****************************************************************************/

/**
 * Uncommenting to disable the Block Inspector control tabs for *all* blocks.
 * The inspector controls will display as they did pre-WP 6.2
 */

//add_filter('block_editor_settings_all', 'snt_disable_tabs_by_default');

function snt_disable_tabs_by_default($settings) {
  $settings['blockInspectorTabs'] = array('default' => false);
  return $settings;
}

/**
 * Uncomment this filter to disable the Block Inspector control tabs
 * for this block *only*. The inspector controls will display as they did pre-WP 6.2
 */
//add_filter('block_editor_settings_all', 'snt_disable_tabs_for_this_block');

function snt_disable_tabs_for_this_block($settings) {
  if (!is_array($settings)) {
    return;
  }

  $current_tab_settings = array_key_exists('blockInspectorTabs', $settings)
    ? $settings['blockInspectorTabs']
    : array();

  $settings['blockInspectorTabs'] = array_merge(
    $current_tab_settings,
    array('snt/inspector-controls' => false)
  );

  return $settings;
}

<?php

/**
 * Register the settings page
 * 
 * $page_title The text to be displayed in the title tags of the page when the menu is selected.
 * $menu_title The text to be used for the menu.
 * $capability The capability required for this menu to be displayed to the user.
 * $menu_slug  The slug name to refer to this menu by (should be unique for this menu).
 * $callback   Optional. The function to be called to output the content for this page.
 * $position   Optional. The position in the menu order this item should appear.
 */
add_action('admin_menu', 'snt_settings_page_register_page');

function snt_settings_page_register_page() {
  add_options_page(
    __('SNT Settings Page', 'snt'),
    __('SNT Settings Page', 'snt'),
    'manage_options',
    'snt-settings-page',
    'snt_settings_page_cb'
  );
}

/**
 * Callback.
 * 
 * 'Loading...' is replaced by the HTML rendered by the React component.
 */

function snt_settings_page_cb() {
  printf(
    '<div class="wrap" id="snt-settings-page">%s</div>',
    esc_html__('Loading…', 'snt')
  );
}

/**
 * Register the options
 * 
 * $option_group Default allowed option key names include 'general', 'discussion', 'media', 'reading', 'writing', and 'options'
 * $option_name The name of an option to sanitize and save.
 * 
 * $args
 *    $type The type of data associated with this setting. Valid values are 'string', 'boolean', 'integer', 'number', 'array', and 'object'.
 *    $label A label of the data attached to this setting.
 *    $description A description of the data attached to this setting.
 *    $sanitize_callback A callback function that sanitizes the option's value.
 *    $default Default value when calling `get_option()`.
 */
add_action('init', 'snt_settings_page_register_settings');

function snt_settings_page_register_settings() {
  $default = array(
    'message' => __('Hello, World!', 'snt'),
    'display' => true,
    'size'    => 'medium',
  );
  $schema  = array(
    'type'       => 'object',
    'properties' => array(
      'message' => array(
        'type' => 'string',
      ),
      'display' => array(
        'type' => 'boolean',
      ),
      'size'    => array(
        'type' => 'string',
        'enum' => array(
          'small',
          'medium',
          'large',
          'x-large',
        ),
      ),
    ),
  );

  register_setting(
    'options',
    'snt_settings_page',
    array(
      'type'         => 'object',
      'default'      => $default,
      'show_in_rest' => array(
        'schema' => $schema,
      ),
    )
  );
}

/**
 * Use the settings on the front end.
 */

function snt_render_settings_on_frontend() {
  $options = get_option('snt_settings_page');

  if (! $options['display']) {
    return;
  }

  $css = WP_Style_Engine::compile_css(
    array(
      'background' => 'var(--wp--preset--color--vivid-purple, #9b51e0)',
      'color'      => 'var(--wp--preset--color--white, #ffffff)',
      'padding'    => 'var(--wp--preset--spacing--20, 1.5rem)',
      'font-size'  => $options['size'],
    ),
    ''
  );

  printf(
    '<div style="%s">%s</div>',
    esc_attr($css),
    esc_html($options['message'])
  );
}

add_action('wp_body_open', 'snt_render_settings_on_frontend');

/**
 * Enqueue the JS.
 * 
 * This uses a dummy block to provide @wordpress/scripts with and entry point.
 * However, block code is not enqueued on settings pages, therefore it is enqueued here.
 */
add_action('admin_enqueue_scripts', 'snt_enqueue_settings_page_script');

function snt_enqueue_settings_page_script($admin_page) {
  if ('settings_page_snt-settings-page' !== $admin_page) {
    return;
  }

  $asset_file = plugin_dir_path(__FILE__) . 'settings-page.asset.php';

  if (! file_exists($asset_file)) {
    return;
  }

  $asset = include $asset_file;

  // Enqueue the JS file for the settings page
  wp_enqueue_script(
    'snt-settings-page',
    plugins_url('settings-page.js', __FILE__),
    $asset['dependencies'],
    $asset['version'],
    array(
      'in_footer' => true,
    )
  );

  // Editor styles. array_filter() protects against unregistered styles.
  wp_enqueue_style(
    'snt-settings-page',
    plugins_url('style-settings-page.css', __FILE__),
    array_filter(
      $asset['dependencies'],
      function ($style) {
        return wp_style_is($style, 'registered');
      }
    ),
    $asset['version'],
  );
}

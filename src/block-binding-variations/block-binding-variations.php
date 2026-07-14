<?

/**
 * Define the message that can not be edited
 */
define('TEXT_LOCK_MESSAGE', "This can't <em>edit</em> this text!");

/**
 * Register a dummy block to provide a entry point
 */
add_action('init', 'snt_register_block_binding_variations');

function snt_register_block_binding_variations() {
  register_block_type(__DIR__);
}

/**
 * Register the block binding. The CB just returns the message
 */
add_action('init', function () {
  register_block_bindings_source('snt/block-binding-variations-no-edit', array(
    'label'               => __('Locked Text'),
    'uses_context'        => ['postID'],
    'get_value_callback'  => function () {
      return TEXT_LOCK_MESSAGE;
    },
  ));
});

/**
 * Make TEXT_LOCK_MESSAGE available to the JS 
 */
add_action('enqueue_block_editor_assets', 'snt_lock_binding_variations_enqueue_message');

function snt_lock_binding_variations_enqueue_message() {
  $text_lock_message = "This can't <em>edit</em> this text!";

  wp_add_inline_script(
    'snt-block-binding-variations-editor-script',
    'const textLockMessage = "' . TEXT_LOCK_MESSAGE . '"',
    'before'
  );
}

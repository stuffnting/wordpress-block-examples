/**
 * WordPress dependencies
 */
import { registerBlockBindingsSource } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";

import metadata from "./block.json";

/**
 * Define which bound post-fields can be edited by the user.
 * The binding works both ways, for example the post title can be edited
 * from the title block or the bound block.
 */
const readOnlyAttributes = ["permalink"];
const editableAttributes = ["title", "excerpt"];

/**
 * Register the block binding source.
 */
registerBlockBindingsSource({
  name: "snt/block-binding-custom-source-pattern", // Must match the name in the PHP file
  //label: __('Bind Post Data', 'snt'), // This is set in the PHP file, and does not need to be reset here
  // usesContext: ["postType"], // postId is set the in PHP file, and should not be reset here
  getValues({ select, bindings }) {
    const values = {};

    /**
     * Note, each binding `key` in the editor HTML has been set to the correct value to use
     * with getEditedPostAttribute()
     */
    for (const [attributeName, source] of Object.entries(bindings)) {
      if (editableAttributes.includes(source.args.key) || readOnlyAttributes.includes(source.args.key)) {
        values[attributeName] = select("core/editor").getEditedPostAttribute(source.args.key);
      }
    }

    return values;
  },
  setValues({ dispatch, bindings }) {
    const values = {};

    /**
     * Note, each binding `key` in the editor HTML has been set to the correct value to use
     * with getEditedPostAttribute()
     */
    for (const [attributeName, source] of Object.entries(bindings)) {
      values[source.args.key] = source.newValue;
    }

    console.log(values);

    if (Object.keys(values).length > 0) {
      dispatch("core/editor").editPost(values);
    }
  },
  canUserEditValue({ context, args }) {
    // Which context is passed depends on those specified in the register_block_bindings_source() use_context argument.
    return "post" === context.postType && editableAttributes.includes(args.key);
  },
});

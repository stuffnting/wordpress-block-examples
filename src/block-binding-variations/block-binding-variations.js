import { __ } from "@wordpress/i18n";
import { registerBlockVariation, registerBlockBindingsSource } from "@wordpress/blocks";

registerBlockVariation("core/group", {
  name: "snt/block-binding-variations-group",
  title: __("SNT Block Binding Variations", "snt"),
  description: __("SNT test block binding variations.", "snt"),
  icon: "lightbulb",
  category: "snt-block-category",
  scope: ["inserter"], // Appears in the inserter as if it were a separate block.
  attributes: {
    templateLock: "all",
    layout: { type: "constrained" },
    metadata: { name: "SNT Block Binding Variations" },
  },
  innerBlocks: [
    [
      "core/paragraph",
      {
        metadata: {
          bindings: {
            content: {
              source: "core/post-data",
              args: { field: "date" },
            },
          },
        },
      },
    ],
    [
      "core/paragraph",
      {
        metadata: {
          bindings: {
            content: {
              source: "core/post-data",
              args: { field: "link" },
            },
          },
        },
      },
    ],
    [
      "core/paragraph",
      {
        metadata: {
          bindings: {
            content: {
              source: "snt/block-binding-variations-no-edit",
            },
          },
        },
      },
    ],
  ],
});

/**
 * Register the block binding for the uneditable text.
 */
registerBlockBindingsSource({
  name: "snt/block-binding-variations-no-edit",
  label: __("Completely locked text example", "snt"),
  getValues({ bindings, context, select }) {
    return { content: textLockMessage };
  },
});

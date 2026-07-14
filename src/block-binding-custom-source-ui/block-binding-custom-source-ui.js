/**
 * WordPress dependencies
 */
import { registerBlockBindingsSource } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { store as blockEditorStore } from "@wordpress/block-editor";

import metadata from "./block.json";

registerBlockBindingsSource({
  name: "snt/block-binding-custom-source-ui-image",
  //label: __('Bind Post Data', 'snt'), // This is set in the PHP file, and does not need to be reset here
  // usesContext: ["postType"], // postId is set the in PHP file, and should not be reset here
  getValues: ({ bindings, context, select }) => {
    const values = {};

    if (bindings.url?.args?.key === "image_url") {
      values.url = "https://pd.w.org/2023/04/893642d3da2481166.65757956.jpg";
    }

    if (bindings.alt?.args?.key === "alt") {
      values.alt = __("A small black and brown dog is swimming in a pool with clear turquoise water.", "snt");
    }

    if (bindings.caption?.args?.key === "image_caption") {
      values.caption = __("Photo by: Carole", "snt");
    }

    return values;
  },
  getFieldsList({ select, context }) {
    const selectedBlock = select(blockEditorStore).getSelectedBlock();

    if (selectedBlock.name !== "core/image") {
      return []; // Hides the binding dropdown choices completely for other blocks
    }

    return [
      {
        label: __("Image URL", "snt"),
        type: "string",
        args: { key: "image_url" },
      },
      {
        label: __("Caption", "snt"),
        type: "string",
        args: { key: "image_caption" },
      },
      {
        label: __("Alt", "snt"),
        type: "string",
        args: { key: "alt" },
      },
    ];
  },
});

registerBlockBindingsSource({
  name: "snt/block-binding-custom-source-ui-button",
  label: __("Editor Button Example", "snt"),
  getValues: ({ bindings, context, select }) => {
    const values = {};

    if (bindings.url?.args?.key === "button_url") {
      values.url = "https://brh.org.uk";
    }

    if (bindings.text?.args?.key === "button_text") {
      values.text = __("Push my buttons", "snt");
    }

    return values;
  },
  getFieldsList({ select, context }) {
    const selectedBlock = select(blockEditorStore).getSelectedBlock();

    if (selectedBlock.name !== "core/button") {
      return []; // Hides the binding dropdown choices completely for other blocks
    }

    return [
      {
        label: __("Button URL", "snt"),
        type: "string",
        args: { key: "button_url" },
      },
      {
        label: __("Text", "snt"),
        type: "string",
        args: { key: "button_text" },
      },
    ];
  },
});

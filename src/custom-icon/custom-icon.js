import { useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";

import metadata from "./block.json";
import style from "./style.css"; // Gets renamed to style-block-json-assets.css.
import { CustomIcon } from "./icon.js";

registerBlockType(metadata, {
  icon: {
    src: CustomIcon,
    foreground: "pink",
    background: "red",
  },
  edit: () => {
    return (
      <div {...useBlockProps()}>
        <h2>A block with a custom icon</h2>
      </div>
    );
  },
  save: () => null,
});

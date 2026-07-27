/**
 * @wordpress imports
 */
import { useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";

/**
 * Local imports
 */
import { CustomIcon } from "./icons.js";
import metadata from "./block.json";

registerBlockType(metadata, {
  icon: {
    src: CustomIcon,
    foreground: "pink",
    background: "red",
  },
  edit: () => {
    return <p {...useBlockProps()}>A test block!!!!</p>;
  },
  save: () => null,
});

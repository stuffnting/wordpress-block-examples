/**
 * WordPress imports
 */
import { registerBlockType } from "@wordpress/blocks";

/**
 * Local imports
 */
import "./style.scss";
import "./editor.scss";

import Edit from "./edit.js";
import metadata from "./block.json";

/**
 * Register the block
 */
registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

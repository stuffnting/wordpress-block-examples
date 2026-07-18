/**
 * WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";

/**
 * Local dependencies
 */
import metadata from "./block.json";
import Edit from "./edit.js";
import css from "./style.scss";

registerBlockType(metadata, {
  edit: Edit,
  save: () => null,
});

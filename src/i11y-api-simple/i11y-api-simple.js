/**
 * Register WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";

/**
 * Internal dependencies
 */
import Edit from "./edit.js";
import metadata from "./block.json";
import css from "./style.scss";
import cssEditor from "./editor.scss";

registerBlockType(metadata.name, {
  edit: Edit,
  save: () => null,
});

/**
 * WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";

/**
 * Local dependencies
 */
import metadata from "./block.json";
import { edit } from "./edit.js";
import { save } from "./save.js";
import { transforms } from "./transforms.js";

registerBlockType(metadata.name, {
  edit,
  save,
  transforms,
});

import { useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import { useSelect, useDispatch } from "@wordpress/data";

import Edit from "./edit.js";
import metadata from "./block.json";

registerBlockType(metadata, {
  edit: Edit,
  save: () => null,
});

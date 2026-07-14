import { useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import { useSelect, useDispatch } from "@wordpress/data";

import Edit from "./dynamic-block-render-function.edit.js";
import metadata from "./block.json";

registerBlockType(metadata, {
  edit: Edit,
  save: () => null,
});

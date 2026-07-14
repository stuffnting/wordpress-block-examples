import { useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import { useSelect, useDispatch } from "@wordpress/data";

import Edit from "./dynamic-block-render-file.edit.js";
import metadata from "./block.json";

registerBlockType(metadata, {
  edit: Edit,
  save: () => null,
});

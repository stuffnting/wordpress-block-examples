import { useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import ServerSideRender from "@wordpress/server-side-render";

import metadata from "./block.json";
import style from "./style.css"; // Gets renamed to style-block-json-assets.css.
import editorStyle from "./editor.css"; // Gets renamed to style-block-json-assets.css.

registerBlockType(metadata, {
  edit: () => {
    return (
      <div {...useBlockProps()}>
        {/* Not passing an attribute object causes and error. Empty object passed. */}
        <ServerSideRender block={metadata.name} attributes={{}} skipBlockSupportAttributes />
      </div>
    );
  },
  save: () => null,
});

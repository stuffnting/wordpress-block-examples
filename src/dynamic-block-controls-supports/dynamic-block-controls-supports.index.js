/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";

// Only needed for server-side render
import ServerSideRender from "@wordpress/server-side-render";

/**
 * Local dependencies
 */

// Only needed for JS render
// import { GetPosts } from "./get-posts.js";
// import { PostListTitle } from "./post-list-title.js";
import { TheInspectorControls } from "./the-inspector-controls.js";

import metadata from "./block.json";
import scss from "./style.scss";

registerBlockType(metadata.name, {
  edit: (props) => {
    const blockProps = useBlockProps();
    const { attributes } = props;

    /**
     * Server-side render
     */

    return (
      <>
        <TheInspectorControls parentProps={props} />
        <div {...blockProps}>
          <ServerSideRender block={metadata.name} attributes={attributes} skipBlockSupportAttributes />
        </div>
      </>
    );

    /**
     * JS render
     */
    /*     return (
      <>
        <TheInspectorControls parentProps={props} />
        <div {...blockProps}>
          <PostListTitle parentProps={props} />
          <GetPosts />
        </div>
      </>
    ); */
  },
  save: () => {
    // For dynamic blocks without inner blocks return null
    return null;
  },
});

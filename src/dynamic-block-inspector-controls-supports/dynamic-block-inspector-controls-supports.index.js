/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";
import ServerSideRender from "@wordpress/server-side-render";
import { RawHTML } from "@wordpress/element";
import { useServerSideRender } from "@wordpress/server-side-render";

/**
 * Local dependencies
 */
import { GetPosts } from "./get-posts.js";
import { PostListTitle } from "./post-list-title.js";
import { TheInspectorControls } from "./the-inspector-controls.js";
import metadata from "./block.json";
import scss from "./style.scss";

registerBlockType(metadata.name, {
  edit: (props) => {
    const blockProps = useBlockProps();
    const { attributes } = props;

    return (
      <>
        <TheInspectorControls parentProps={props} />
        <div {...blockProps}>
          <ServerSideRender block={metadata.name} attributes={attributes} skipBlockSupportAttributes />
        </div>
      </>
    );
    /*     const { content, status, error } = useServerSideRender({
      attributes,
      block: metadata.name,
    });

    if (status === "loading") {
      return <div>Loading...</div>;
    }

    if (status === "error") {
      return <div>Error: {error}</div>;
    }

    return (
      <>
        <TheInspectorControls parentProps={props} />
        <div {...blockProps}>
          <RawHTML>{content}</RawHTML>
        </div>
      </>
    ); */

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

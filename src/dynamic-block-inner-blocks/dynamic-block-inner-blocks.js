/**
 * WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

/**
 * Local dependencies
 */
import { GetPosts } from "./get-posts.js";
import metadata from "./block.json";
import scss from "./style.scss";

const allowedBlocks = ["core/paragraph", "core/heading", "core/list"];

registerBlockType(metadata.name, {
  edit: () => {
    const blockProps = useBlockProps();
    const innerBlockProps = useInnerBlocksProps({}, { allowedBlocks });

    return (
      <div {...blockProps}>
        <h2>Last Posts</h2>
        <p>The hot FIVE!</p>
        <GetPosts />
        {innerBlockProps.children}
      </div>
    );
  },
  save: () => {
    const innerBlocksProps = useInnerBlocksProps.save();
    // Return only the inner blocks, without a wrapping tag.
    return <>{innerBlocksProps.children}</>;
  },
});

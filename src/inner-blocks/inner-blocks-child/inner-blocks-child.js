/**
 * WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps } from "@wordpress/block-editor";

/**
 * Local dependencies
 */
import metadata from "./block.json";
import css from "./style.scss";

registerBlockType(metadata.name, {
  edit: () => {
    const blockProps = useBlockProps();

    return (
      <div {...blockProps}>
        <h2>I am a child</h2>
      </div>
    );
  },
  save: () => {
    const blockProps = useBlockProps.save();

    return (
      <div blockProps>
        <h2>I am a child</h2>
      </div>
    );
  },
});

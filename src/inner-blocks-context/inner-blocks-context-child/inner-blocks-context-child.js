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
  edit: ({ context }) => {
    const blockProps = useBlockProps();

    return (
      <div {...blockProps}>
        <h2>I am a child</h2>
        <p>My Number IS: {context["snt/myNumber"]}</p>
      </div>
    );
  },
  save: () => null, // No access to context here!
});

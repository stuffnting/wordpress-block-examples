/**
 * WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

/**
 * Local dependencies
 */
import metadata from "./block.json";

const TEMPLATE = [
  [
    "core/heading",
    {
      level: 2,
      lock: { move: true, remove: true },
      placeholder: "Enter a locked heading",
    },
  ],
  ["core/image", {}],
  ["core/paragraph", { placeholder: "Image Details" }],
];

const ALLOWED = ["core/paragraph", "core/list"];

registerBlockType(metadata.name, {
  edit: () => {
    const blockProps = useBlockProps();
    const innerBlockProps = useInnerBlocksProps(blockProps, {
      allowedBlocks: ALLOWED,
      template: TEMPLATE,
      templateLock: false,
    });

    return <div {...innerBlockProps} />;
  },
  save: () => {
    const blockProps = useBlockProps.save();
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return <div {...innerBlocksProps} />;
  },
});

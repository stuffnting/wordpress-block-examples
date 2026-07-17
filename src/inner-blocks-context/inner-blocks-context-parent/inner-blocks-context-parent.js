import { registerBlockType } from "@wordpress/blocks";
import { RangeControl } from "@wordpress/components";
import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

import { useSelect } from "@wordpress/data";

/**
 * Local dependencies
 */
import metadata from "./block.json";

/******************************************************************************
 *
 * Parent block
 *
 *****************************************************************************/
const MY_TEMPLATE = [
  ["snt/inner-blocks-context-child", {}],
  ["core/spacer", { height: "100px" }],
  [
    "core/paragraph",
    {
      content:
        "The next two children are nested in columns. The myNumber is passed down without 'without prop-drilling'",
    },
  ],
  ["core/spacer", { height: "25px" }],
  [
    "core/columns",
    {},
    [
      ["core/column", {}, [["snt/inner-blocks-context-child", {}]]],
      ["core/column", {}, [["snt/inner-blocks-context-child", {}]]],
    ],
  ],
];

registerBlockType(metadata.name, {
  edit: (props) => {
    // Only allow the child block as an inner block.
    const blockProps = useBlockProps();
    const innerBlocksProps = useInnerBlocksProps(
      {},
      {
        template: MY_TEMPLATE,
        templateLock: "all",
      },
    );

    const {
      attributes: { myNumber },
      setAttributes,
    } = props;

    return (
      <div {...blockProps}>
        <RangeControl
          label="Pick a number"
          value={myNumber}
          onChange={(val) => setAttributes({ myNumber: Number(val) })}
          min={0}
          max={10}
          withInputField={false}
          icon="lightbulb"
        />
        <div {...innerBlocksProps} />
      </div>
    );
  },

  save: ({ attributes }) => {
    const blockProps = useBlockProps.save();
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);
    // This just returns the inner blocks, including the child block, but returns nothing from the parent
    return <div {...innerBlocksProps} />;
  },
});

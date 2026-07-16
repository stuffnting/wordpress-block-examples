import { createBlock } from "@wordpress/blocks";

export const transforms = {
  to: [
    {
      type: "block",
      isMultiBlock: true, // transforms with multiple blocks selected.
      blocks: ["core/paragraph"],
      transform: (attributes) => {
        return [
          createBlock("core/paragraph", { content: attributes[0].heading }),
          createBlock("core/paragraph", { content: attributes[0].content }),
          createBlock("core/paragraph", { content: attributes[0].footer }),
        ];
      },
    },
  ],
};

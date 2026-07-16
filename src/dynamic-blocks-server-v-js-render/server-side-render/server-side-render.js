/**
 * @wordpress import
 */
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import ServerSideRender from "@wordpress/server-side-render";
import { PanelBody, RangeControl } from "@wordpress/components";

/**
 * Local import
 */
import metadata from "./block.json";

registerBlockType(metadata, {
  edit: function ({ attributes, setAttributes }) {
    const { pagesToShow } = attributes;

    return (
      <>
        <InspectorControls>
          <PanelBody title="Query Settings">
            <RangeControl
              label="Number of pages"
              value={pagesToShow}
              min={1}
              max={10}
              onChange={(value) => setAttributes({ pagesToShow: value })}
            />
          </PanelBody>
        </InspectorControls>
        <div {...useBlockProps()}>
          <ServerSideRender block={metadata.name} attributes={{ pagesToShow }} skipBlockSupportAttributes />
        </div>
      </>
    );
  },
  save: () => null,
});

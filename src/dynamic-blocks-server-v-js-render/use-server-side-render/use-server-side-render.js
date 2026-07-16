/**
 * @wordpress import
 */
import { useBlockProps, InspectorControls } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";
import { RawHTML } from "@wordpress/element";
import { useServerSideRender } from "@wordpress/server-side-render";
import { PanelBody, RangeControl } from "@wordpress/components";

/**
 * Local import
 */
import metadata from "./block.json";

registerBlockType(metadata, {
  edit: function ({ attributes, setAttributes }) {
    const { pagesToShow } = attributes;

    const { content, status, error } = useServerSideRender({
      attributes,
      block: metadata.name,
    });

    if (status === "Waiting patiently...") {
      return <div>Loading...</div>;
    }

    if (status === "error") {
      return <div>Big fat error: {error}</div>;
    }

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
          <RawHTML>{content}</RawHTML>
        </div>
      </>
    );
  },
  save: () => null,
});

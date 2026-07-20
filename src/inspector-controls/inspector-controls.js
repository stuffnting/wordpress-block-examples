/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { PanelBody, PanelRow } from "@wordpress/components";
import { InspectorControls, InspectorAdvancedControls, useBlockProps } from "@wordpress/block-editor";
import { registerBlockType } from "@wordpress/blocks";

/**
 * Local dependencies
 */
import metadata from "./block.json";
import css from "./editor.scss";
import "./core-block-extra-panel.js";

registerBlockType(metadata, {
  edit: () => {
    return (
      <div {...useBlockProps()}>
        {/* Add panels to the setting and styles tabs */}
        <InspectorControls>
          <PanelBody title={__("Custom Block Controls", "snt")}>
            {__("Custom block controls added to top of the setting tab because there is no group prop", "snt")}
          </PanelBody>
        </InspectorControls>
        <InspectorControls group="styles">
          <PanelBody title={__("Custom Block Controls", "snt")}>
            {__("Custom block controls added to bottom of the styles tab", "snt")}
          </PanelBody>
        </InspectorControls>
        {/* Add to the existing panels in the styles tab */}
        <InspectorControls group="color">
          <div className="full-width-control-wrapper">
            {__("I'm in the colors group! (Check supports in block.json)", "snt")}
          </div>
        </InspectorControls>
        <InspectorControls group="typography">
          <div className="full-width-control-wrapper">
            {__("I'm in the typography group! (Check supports in block.json)", "snt")}
          </div>
        </InspectorControls>
        <InspectorControls group="dimensions">
          <div className="full-width-control-wrapper">
            {__("I'm in the dimensions group! (Check supports in block.json)", "snt")}
          </div>
        </InspectorControls>
        <InspectorControls group="border">
          <div className="full-width-control-wrapper">
            {__("I'm in the border group! (Check supports in block.json)", "snt")}
          </div>
        </InspectorControls>
        {/* Add to the Advanced group */}
        <InspectorAdvancedControls>{__("I'm in the advanced group!", "snt")}</InspectorAdvancedControls>
        <InspectorControls group="advanced">{__("I'm in the advanced group too!", "snt")}</InspectorControls>
        <h2>Look in the Block Inspector</h2>
      </div>
    );
  },
  save: () => null,
});

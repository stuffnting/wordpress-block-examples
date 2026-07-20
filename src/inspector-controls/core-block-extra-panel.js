// core-block-extra-panel.js
import { createHigherOrderComponent } from "@wordpress/compose";
import { addFilter } from "@wordpress/hooks";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

console.log("SNT: core-block-extra-panel.js loaded");

const sntAddExtraCorePanel = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    if (props.name !== "core/heading") {
      return <BlockEdit {...props} />;
    }

    return (
      <>
        <InspectorControls>
          <PanelBody title="SNT Injected Top Panel" initialOpen={false}>
            {__("I have been added to the core/paragraph inspector controls.", "snt")}
          </PanelBody>
        </InspectorControls>
        <BlockEdit {...props} />
      </>
    );
  };
}, "withTopInspectorControl");

addFilter("editor.BlockEdit", "snt/core-heading-extra-panel", sntAddExtraCorePanel);

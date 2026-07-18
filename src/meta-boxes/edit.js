/**
 * Wordpress dependencies
 */
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText, InspectorControls } from "@wordpress/block-editor";
import { useEntityProp } from "@wordpress/core-data";
import { RangeControl, PanelBody } from "@wordpress/components";

/**
 * Local dependencies
 */
import metadata from "./block.json";
import { sntRunRegisterPlugin } from "./plugin-sidebar.js";
import { sntDocumentSettings } from "./document-settings.js";

sntRunRegisterPlugin();
sntDocumentSettings();

const metaField = metadata.attributes.sntMeta.default;

export default function Edit({ context }) {
  const { postType, postId } = context;
  const [meta, setMeta] = useEntityProp("postType", postType, "meta", postId);

  function updateMetaValue(newValue, key) {
    const newMetaObj = {
      ...meta[metaField],
      [key]: newValue,
    };

    setMeta({ ...meta, [metaField]: newMetaObj });
  }

  return (
    <>
      <InspectorControls>
        <PanelBody title={__("Number", "textDomain")} initialOpen={false} icon="lightbulb">
          <RangeControl
            help="Pick a number."
            label="Opacity"
            withInputField={false}
            initialPosition={5}
            max={10}
            min={0}
            value={meta[metaField].number}
            onChange={(newValue) => updateMetaValue(newValue, "number")}
          />
        </PanelBody>
      </InspectorControls>
      <div {...useBlockProps()}>
        <RichText
          placeholder={__("Type some RichText...", "snt")}
          tagName="p"
          value={meta[metaField].richtext}
          onChange={(newValue) => updateMetaValue(newValue, "richtext")}
        />
        <p>Colour: {meta[metaField].colour}</p>
        <p>DateTime: {meta[metaField].datetime}</p>
        <p>Number: {meta[metaField].number}</p>
        <p>Radio: {meta[metaField].radio}</p>
      </div>
    </>
  );
}

/**
 * Wordpress dependencies
 */
import { __ } from "@wordpress/i18n";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { useEntityProp } from "@wordpress/core-data";

/**
 * Local dependencies
 */
import metadata from "./block.json";

const metaField = metadata.attributes.sntMeta.default;

export default function Edit({ context }) {
  const { postType, postId } = context;
  const [meta, setMeta] = useEntityProp("postType", postType, "meta", postId);
  const metaFieldValue = meta[metaField];

  function updateMetaValue(newValue) {
    setMeta({ ...meta, [metaField]: newValue });
  }

  return (
    <div {...useBlockProps()}>
      <RichText
        placeholder={__("Type something...", "tutorial")}
        tagName="p"
        value={metaFieldValue}
        onChange={updateMetaValue}
      />
    </div>
  );
}

/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import { RadioControl } from "@wordpress/components";
import { useEntityProp } from "@wordpress/core-data";
import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";

/**
 * Local dependencies
 */
// This is not a block.json file. It stores the meta field name,so that it is accessible to JS and PHP
import metadata from "./block.json";

// The meta field name is defined in the JSON file
const metaField = metadata.attributes.sntMeta.default;

/********************************************************************
 *
 * React components that adds a meta field
 *
 ********************************************************************/

const DocPanelMetaFields = () => {
  const postType = useSelect((select) => select("core/editor").getCurrentPostType(), []);

  const [meta, setMeta] = useEntityProp("postType", postType, "meta");
  const metaFieldValue = meta[metaField].radio;

  // The key is the element in the metaField array to update
  function updateMetaValue(newValue, key) {
    const newMetaObj = {
      ...meta[metaField],
      [key]: newValue,
    };

    setMeta({ ...meta, [metaField]: newMetaObj });
  }

  return (
    <RadioControl
      label="Choose a station"
      onChange={(newValue) => updateMetaValue(newValue, "radio")}
      options={[
        {
          label: "BBC Radio 1",
          value: "BBC Radio 1",
        },
        {
          label: "BBC Radio 2",
          value: "BBC Radio 2",
        },
        {
          label: "BBC Radio 3",
          value: "BBC Radio 3",
        },
        {
          label: "BBC Radio 4",
          value: "BBC Radio 4",
        },
        {
          label: "BBC Radio 5",
          value: "BBC Radio 5",
        },
      ]}
      selected={metaFieldValue}
    />
  );
};

/********************************************************************
 *
 * Register the plugin to create the sidebar and the
 * Document Settings Panel meta box
 *
 ********************************************************************/

export function sntDocumentSettings() {
  registerPlugin("snt-meta-boxes-document-settings", {
    icon: "lightbulb",
    render: () => {
      return (
        <>
          <PluginDocumentSettingPanel
            name="snt-meta-boxes-document-settings-panel"
            title="SNT Meta Document Settings"
            icon="lightbulb">
            <DocPanelMetaFields />
          </PluginDocumentSettingPanel>
        </>
      );
    },
  });
}

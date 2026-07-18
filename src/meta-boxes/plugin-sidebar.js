/**
 * This code does not register a block type.
 */

/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { useSelect } from "@wordpress/data";
import { DateTimePicker, ColorPicker, PanelBody } from "@wordpress/components";
import { PluginSidebar, PluginSidebarMoreMenuItem } from "@wordpress/edit-post";
import { useEntityProp } from "@wordpress/core-data";
import { registerPlugin } from "@wordpress/plugins";

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

function PluginSidebarMetaFields() {
  const postType = useSelect((select) => select("core/editor").getCurrentPostType(), []);

  const [meta, setMeta] = useEntityProp("postType", postType, "meta");
  const colour = meta[metaField].colour || "";
  const datetime = meta[metaField].datetime || "";

  // The key is the element in the metaField array to update
  function updateMetaValue(newValue, key) {
    const newMetaObj = {
      ...meta[metaField],
      [key]: newValue,
    };

    setMeta({ ...meta, [metaField]: newMetaObj });
  }

  return (
    <>
      <PanelBody title={__("A colour picker", "textDomain")} icon="lightbulb" initialOpen={true}>
        <ColorPicker
          color={colour}
          label={__("Colour Meta", "textDomain")}
          onChangeComplete={(newValue) => updateMetaValue(newValue.hex, "colour")}
          disableAlpha
        />
      </PanelBody>
      <PanelBody title={__("A DateTime picker", "textDomain")} icon="lightbulb" initialOpen={true}>
        <DateTimePicker
          currentDate={datetime}
          onChange={(newValue) => updateMetaValue(newValue, "datetime")}
          is12Hour={false}
        />
      </PanelBody>
    </>
  );
}

/******************************************************************************
 *
 * Register the plugin with Gutenberg and create the sidebar.
 *
 *****************************************************************************/
export function sntRunRegisterPlugin() {
  registerPlugin("snt-meta-boxes-plugin-sidebar", {
    icon: "lightbulb",
    render: () => {
      return (
        <>
          <PluginSidebarMoreMenuItem target="snt-meta-boxes-plugin-sidebar">
            {__("Meta Options", "textDomain")}
          </PluginSidebarMoreMenuItem>
          <PluginSidebar name="snt-meta-boxes-plugin-sidebar" title={__("SNT Plugin Sidebar", "textDomain")}>
            <PluginSidebarMetaFields />
          </PluginSidebar>
        </>
      );
    },
  });
}

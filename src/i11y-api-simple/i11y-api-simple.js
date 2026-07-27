/**
 * Register WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

/**
 * Internal dependencies
 */
import metadata from "./block.json";
import css from "./style.scss";
import cssEditor from "./editor.scss";

registerBlockType(metadata.name, {
  edit: ({ attributes, setAttributes }) => {
    const blockProps = useBlockProps();
    return <p {...blockProps}>{__("I11y Api Simple - hello from the editor!", "textDomain")}</p>;
  },
  save: () => null,
});

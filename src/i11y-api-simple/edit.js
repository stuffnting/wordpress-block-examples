/**
 * Wordpress imports
 */
import { __ } from "@wordpress/i18n";
import { useBlockProps } from "@wordpress/block-editor";

export default function Edit({ attributes, setAttributes }) {
  const blockProps = useBlockProps();

  return <p {...blockProps}>{__("I11y Api Simple - hello from the editor!", "textDomain")}</p>;
}

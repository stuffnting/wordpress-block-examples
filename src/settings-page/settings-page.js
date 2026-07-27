/**
 * @wordpress dependencies
 */
import domReady from "@wordpress/dom-ready";
import { createRoot } from "@wordpress/element";

/**
 * Local dependencies
 */
import { Settings } from "./settings.js";
import "./style.scss";

domReady(() => {
  // createRoot creates a React root for displaying content inside a browser DOM element.
  const root = createRoot(document.getElementById("snt-settings-page"));

  root.render(<Settings />);
});

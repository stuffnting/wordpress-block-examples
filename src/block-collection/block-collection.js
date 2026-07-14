import { registerBlockCollection } from "@wordpress/blocks";

import metadata from "./block.json";

// The collection is registered for the "snt" namespace.
registerBlockCollection("snt", {
  title: "SNT Blocks",
  icon: "lightbulb",
});

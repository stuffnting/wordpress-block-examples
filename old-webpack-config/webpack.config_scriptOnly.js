import defaultConfig from "@wordpress/scripts/config/webpack.config.js";
import CopyWebpackPlugin from "copy-webpack-plugin";
import { readFileSync } from "fs";
import { fileURLToPath } from "url";
import { sep } from "node:path";

// Read and parse the build-list.json safely
const exampleJSON = readFileSync(new URL("./src/build-list.json", import.meta.url), "utf8");
const exampleList = JSON.parse(exampleJSON);

console.log(defaultConfig[1]);

/**
 * Make a lists of examples to include and omit
 */
const processedExampleList = Object.entries(exampleList).reduce(
  (acc, [exampleName, details]) => {
    const { include, omit } = acc;

    if (details.include) {
      return { include: [...include, exampleName], omit };
    }

    return { include, omit: [...omit, exampleName] };
  },
  { include: [], omit: [] },
);

const omitFromBuildList = processedExampleList.omit;
const includeInBuildList = processedExampleList.include;

/**
 * Make a new entry point list
 */
const defaultEntryPoints = defaultConfig.entry();

// Remove examples in the omit list from WP's default entry point list
const filteredEntryPoints = Object.keys(defaultEntryPoints).reduce((acc, entryName) => {
  // Check if the current entry path matches any omitted folder name
  //const shouldOmit = omitFromBuildList.some((folder) => entryName.split(sep)[0].match(folder));
  const shouldOmit = omitFromBuildList.some((folder) => entryName.split(sep)[0] === folder);

  if (!shouldOmit) {
    acc[entryName] = defaultEntryPoints[entryName];
  }

  return acc;
}, {});

console.log("##### Omit #####");
console.log(omitFromBuildList);
console.log("##### Include #####");
console.log(includeInBuildList);
console.log("##### Entry Point list #####");
console.log(filteredEntryPoints);

/**
 * Make new copyPlugin patterns
 */
const staticCopy = [
  {
    from: "build-list.json",
    context: "src",
    noErrorOnMissing: false,
  },
  {
    from: "index.php",
    context: "src",
    noErrorOnMissing: false,
  },
];

// Get the original JSON pattern so that the original transform function can be used
const jsonPattern = defaultConfig.plugins[2].patterns[0];

// Make a list of copy patterns for the block.json and *.php files in the included examples only
const copyPatterns = includeInBuildList.reduce((acc, example) => {
  return [
    ...acc,
    {
      ...jsonPattern,
      from: `${example}/**/block.json`,
    },
    {
      from: `${example}/**/*.php`,
      context: "src",
      noErrorOnMissing: false,
    },
  ];
}, []);

// Remove WP's default copyPlugin entry
const filteredPlugins = defaultConfig.plugins.filter((plugin) => plugin.constructor.name !== "CopyPlugin");

// Make a new copyPlugin
const newPlugins = [
  ...filteredPlugins,
  new CopyWebpackPlugin({
    patterns: [...copyPatterns, ...staticCopy],
  }),
];

/**
 * Export
 */
export default (env, argv) => {
  return {
    ...defaultConfig,
    entry: filteredEntryPoints, // Pass the static filtered object directly
    plugins: newPlugins,
  };
};

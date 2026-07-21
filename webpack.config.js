import defaultConfig from "@wordpress/scripts/config/webpack.config.js";
import CopyWebpackPlugin from "copy-webpack-plugin";
import { readFileSync } from "fs";
import { sep } from "node:path";

// Read and parse the build-list.json safely
const exampleJSON = readFileSync(new URL("./src/build-list.json", import.meta.url), "utf8");
const exampleList = JSON.parse(exampleJSON);

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

console.log("##### Omit #####");
console.log(omitFromBuildList);
console.log("##### Include #####");
console.log(includeInBuildList);

/**
 * Static files copied regardless of which examples are included
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

/**
 * Filter a config's entry points, dropping anything in the omit list.
 * Works whether `entry` is a plain object or (as wp-scripts uses)
 * a dynamic-entry function that must be invoked to get the object.
 */
function getFilteredEntryPoints(config) {
  const entryPoints = typeof config.entry === "function" ? config.entry() : config.entry;

  return Object.keys(entryPoints).reduce((acc, entryName) => {
    const shouldOmit = omitFromBuildList.some((folder) => entryName.split(sep)[0] === folder);

    if (!shouldOmit) {
      acc[entryName] = entryPoints[entryName];
    }

    return acc;
  }, {});
}

/**
 * Build the block.json / *.php copy patterns for the included examples,
 * reusing the default plugin's block.json transform function.
 */
function buildCopyPatterns(jsonPattern) {
  return includeInBuildList.reduce((acc, example) => {
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
}

/**
 * Apply entry filtering + (where present) CopyWebpackPlugin replacement
 * to a single webpack config object.
 */
function transformConfig(config) {
  const filteredEntryPoints = getFilteredEntryPoints(config);

  // Only scriptConfig ships a CopyWebpackPlugin by default; moduleConfig doesn't.
  const copyPluginIndex = config.plugins.findIndex((plugin) => plugin?.constructor?.name === "CopyPlugin");

  let newPlugins = config.plugins;

  if (copyPluginIndex !== -1) {
    const existingCopyPlugin = config.plugins[copyPluginIndex];
    const jsonPattern = existingCopyPlugin.patterns[0];
    const copyPatterns = buildCopyPatterns(jsonPattern);

    newPlugins = [
      ...config.plugins.filter((_, i) => i !== copyPluginIndex),
      new CopyWebpackPlugin({
        patterns: [...copyPatterns, ...staticCopy],
      }),
    ];
  }

  console.log("##### Entry Point list #####");
  console.log(filteredEntryPoints);

  return {
    ...config,
    entry: filteredEntryPoints,
    plugins: newPlugins,
  };
}

/**
 * Export
 */
export default (env, argv) => {
  // With --experimental-modules, wp-scripts exports [scriptConfig, moduleConfig].
  // Without it, it exports a single config object.
  if (Array.isArray(defaultConfig)) {
    return defaultConfig.map(transformConfig);
  }

  return transformConfig(defaultConfig);
};

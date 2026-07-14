import defaultConfig from "@wordpress/scripts/config/webpack.config.js";
import CopyWebpackPlugin from "copy-webpack-plugin";
import path from "path";
import { readFileSync } from "fs";
import { fileURLToPath } from "url";

// Recreate __filename and __dirname
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Read and parse the build list JSON safely
const exampleJSON = readFileSync(new URL("./src/build-list.json", import.meta.url), "utf8");
const exampleList = JSON.parse(exampleJSON);

// FIX 1: Push plain strings, not arrays
const omitFromBuildList = Object.entries(exampleList).reduce((acc, [exampleName, details]) => {
  if (details.include) {
    return acc;
  }

  // Push just the string name
  acc.push(exampleName);

  return acc;
}, []);

export default (env, argv) => {
  // FIX 2: Evaluate defaultConfig as a function if needed
  const config = typeof defaultConfig === "function" ? defaultConfig(env, argv) : defaultConfig;

  // Determine correct output path safely
  const outputPath = argv.outputPath || config.output?.path || path.resolve(__dirname, "build");

  const plugins = [
    ...(config.plugins || []),
    new CopyWebpackPlugin({
      patterns: [
        {
          from: path.resolve(__dirname, "src/build-list.json"),
          to: path.resolve(outputPath, "build-list.json"),
        },
      ],
    }),
  ];

  const defaultBuildList = typeof config.entry === "function" ? config.entry() : config.entry;

  const filteredBuildList = Object.keys(defaultBuildList).reduce((acc, entryName) => {
    // Check if the current entry path matches any omitted folder name
    const shouldOmit = omitFromBuildList.some((folder) => entryName.includes(folder));

    if (!shouldOmit) {
      acc[entryName] = defaultBuildList[entryName];
    }

    return acc;
  }, {});

  return {
    ...config,
    entry: filteredBuildList, // Pass the static filtered object directly
    plugins: plugins,
  };
};

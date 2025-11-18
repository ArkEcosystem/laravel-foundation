import { copyFileSync, existsSync, mkdirSync } from "fs";
import { dirname, resolve } from "path";
import { readFileSync, writeFileSync } from "fs";

import postcss from "postcss";
import postcssImport from "postcss-import";
import tailwindcss from "tailwindcss";

// Helper function to process CSS files
async function processCssFile(src, dest) {
    try {
        const css = readFileSync(src, "utf8");

        // Process with PostCSS plugins, due to import statements and TailwindCSS
        const result = await postcss([postcssImport(), tailwindcss()]).process(
            css,
            {
                from: src,
                to: dest,
            }
        );

        writeFileSync(dest, result.css);
        console.log(`✓ Processed markdown CSS: ${src} to ${dest}`);

        if (result.map) {
            writeFileSync(dest + ".map", result.map.toString());
        }
    } catch (error) {
        console.error(`Error processing markdown CSS ${src}:`, error);
    }
}

const createMarkdownPlugin = (force = false) => {
    return {
        name: "markdown-plugin",
        async buildStart() {
            // Copy markdown editor and related files
            const fileOperations = [
                {
                    type: "copy",
                    src: resolve(
                        process.cwd(),
                        "vendor/arkecosystem/foundation/resources/assets/js/markdown-editor/markdown-editor.js"
                    ),
                    dest: resolve(
                        process.cwd(),
                        "resources/js/markdown-editor.js"
                    ),
                },
                {
                    type: "copy",
                    src: resolve(
                        process.cwd(),
                        "vendor/arkecosystem/foundation/resources/assets/js/markdown-editor/plugins/underline.js"
                    ),
                    dest: resolve(
                        process.cwd(),
                        "resources/js/plugins/underline.js"
                    ),
                },
                {
                    type: "copy",
                    src: resolve(
                        process.cwd(),
                        "vendor/arkecosystem/foundation/resources/assets/js/markdown-editor/utils/utils.js"
                    ),
                    dest: resolve(process.cwd(), "resources/js/utils/utils.js"),
                },
                {
                    type: "process-css",
                    src: resolve(
                        process.cwd(),
                        "vendor/arkecosystem/foundation/resources/assets/css/markdown-editor.css"
                    ),
                    dest: resolve(
                        process.cwd(),
                        "resources/css/markdown-editor.css"
                    ),
                },
            ];

            for (const operation of fileOperations) {
                const { src, dest, type } = operation;
                const destDir = dirname(dest);

                if (!force && existsSync(dest)) {
                    console.log(`ℹ Skipping existing file: ${dest}`);

                    continue;
                }

                // Ensure destination directory exists
                if (!existsSync(destDir)) {
                    mkdirSync(destDir, { recursive: true });
                }

                if (existsSync(src)) {
                    if (type === "copy") {
                        copyFileSync(src, dest);
                        console.log(`✓ Copied markdown JS: ${src} to ${dest}`);
                    } else if (type === "process-css") {
                        // Process CSS with PostCSS first
                        await processCssFile(src, dest);
                    }
                } else {
                    console.warn(`⚠ Could not find markdown file: ${src}`);
                }
            }
        },

        configureServer(server) {},

        buildEnd() {},
    };
};

export default createMarkdownPlugin;

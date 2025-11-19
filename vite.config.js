/**
 * Vite configuration file for Wicket WordPress Theme
 *
 * This file sets up Vite to build and bundle the theme's assets,
 * 
 * Please note that there are a few .ENV variables that can be set to modify Vite's behavior:
 * - VITE_HMR: Set to true to enable Hot Module Replacement for local development. Set to false/remove the line for production builds.
 */

/**
 * TODO:
 *
 * Cleanup Legacy gulp files once Vite is fully implemented.
 * Migrate to TW4 once stable.
 * Do we need to @use tailwind in wicket.scss?
 * Investigate optimizing our tailwind.config.js files to reduce build times.
 * Can we mitigate FOUC when using Vite with WordPress?
 * 
 * 
 * Document whats needed for base plugin and child themes
 */



import { resolve } from "path";
import tailwindcss from "@tailwindcss/vite";

export default {
    root: __dirname, // project root
    plugins: [
        tailwindcss(), // Tailwind v4 Vite plugin
    ],
    build: {
        outDir: "dist", // output directory for built CSS
        sourcemap: true,
        emptyOutDir: true,
        manifest: true, // we can parse this manifest to enqueue files in WordPress
        cssMinify: true,
        rollupOptions: {
            input: {
                wicket: resolve(__dirname, "assets/scripts/wicket.js"), // main JS entry
                wicketadmin: resolve(__dirname, "assets/scripts/wicket-admin.js"), // admin JS entry
            },
        },
    },
    css: {
        preprocessorOptions: {},
    },
    server: {
        // Vite dev server
        host: "127.0.0.1",
        port: 5173,
        strictPort: true,
        hmr: {
            host: "127.0.0.1",
        },
    },
};

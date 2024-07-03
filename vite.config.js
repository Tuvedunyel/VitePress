/* eslint-disable unicorn/prefer-module */
import { defineConfig } from 'vite'
import liveReload from 'vite-plugin-live-reload'
import { resolve } from 'node:path'
import fs from 'node:fs'
import getThemeDir from './js-helpers/get_theme_dir.mjs'

// https://vitejs.dev/config
export default defineConfig({
  plugins: [liveReload(__dirname + '/**/*.php')],

  // config
  root: '',
  base: process.env.NODE_ENV === 'development' ? `/` : `/wp-content/themes/${getThemeDir()}/dist/`,

  build: {
    outDir: resolve(__dirname, './dist'),
    emptyOutDir: true,

    manifest: true,

    // esbuild target
    target: 'es2018',

    rollupOptions: {
      input: {
        main: resolve(__dirname + '/script.ts'),
      },

      /*
      output: {
          entryFileNames: `[name].js`,
          chunkFileNames: `[name].js`,
          assetFileNames: `[name].[ext]`
      }*/
    },

    minify: true,
    write: true,
  },

  server: {
    cors: true,

    strictPort: true,
    port: 3000,

    https: false,

    hmr: {
      host: 'localhost',
      //port: 443
    },
  },

  resolve: {
    alias: {},
  },
})

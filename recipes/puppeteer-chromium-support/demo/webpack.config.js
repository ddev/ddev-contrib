var Encore = require('@symfony/webpack-encore');
var CriticalCssPlugin = require('html-critical-webpack-plugin');

const sane = require("sane");
const path = require("path");

Encore
    // directory where compiled assets will be stored
    .setOutputPath('web/webpack-assets/')
    // public path used by the web server to access the output path
    .setPublicPath('/webpack-assets')
    // only needed for CDN's or sub-directory deploy
    .setManifestKeyPrefix('')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('main', './src/main.js')
    .addStyleEntry('styles', './src/styles.css')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())
    .enablePostCssLoader()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use Sass/SCSS files
//.enableSassLoader()

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;

if (Encore.isProduction()) {
    Encore.addPlugin(new CriticalCssPlugin({
        base: './web/criticalcss/',
        src: 'https://demo.ddev.site/',
        dest: 'critical.min.css',
        extract: false,
        inline: false,
        minify: true,
        width: 1200,
        height: 1200,
    }))
}

module.exports = Encore.getWebpackConfig();

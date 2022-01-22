const tailwindcss = require('tailwindcss');
const autoprefixer = require('autoprefixer');
const purgecss = require("@fullhuman/postcss-purgecss");

module.exports = {
    from: "src/styles.css",
    to: "web/css/styles.css",
    plugins: [
        tailwindcss('./tailwind.config.js'),
        autoprefixer(),
        process.env.NODE_ENV === 'production' && purgecss({
            content: [
                "./web/*.php"
            ],
            whitelistPatternsChildren: [],
            defaultExtractor: content => content.match(/[A-Za-z0-9-_:/]+/g)
        })
    ],
};

# Puppeteer Chromium support

> ⚠️ That recipe was updated to be compatible with latest ddev web container images (1.6 and upper) and Apple Silicon M1 architecture.

Npm packages like codeceptjs or critical-css-webpack-plugin which depend on [Puppeteer](https://github.com/puppeteer/puppeteer/) will not be able to run from within the web container because of some missing Linux libraries.

You can add Puppeteer support to your ddev project by adding the chromium package to your `config.yaml` file and let Puppeteer use it instead of the bundled one:

```yaml
webimage_extra_packages: [chromium]
web_environment:
- PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium
```

## Puppeteer CSS Demo

You will find a proof of concept in the [demo](demo/) folder.

It is based on the [Tailwind CSS Landing Page starter project](https://github.com/tailwindtoolbox/Landing-Page) and demonstrate how to use [Webpack Encore](https://symfony.com/doc/current/frontend.html) to compile javascript and css resources and extract critical CSS with critical-css-webpack-plugin from within the ddev web container.

Obviously, the PHP part is quite minimalistic and is just used to read the webpack manifest file to inject relevant javascript and css files and inline the critical css file in the landing page. However, the overall workflow can easily be adapted in a more complex PHP project using a CMS or a framework.

### Startup

For the root of the [demo](demo/) folder, start the ddev environment:

```
ddev start
```

The provided `.ddev/config.yaml` is pre-configured to include the needed `webimage_extra_packages` in order to run the `critical-css-webpack-plugin`.

### Installation

To install the node dependencies, run `ddev yarn install`

### Generate the webpack assets and the critical CSS file

Run `ddev yarn build`

This will generate optimized javascript and css files in `web/webpack-assets` folder along with the critical css file in the `web/criticalcss` folder using the critical-css-webpack-plugin.

Under the hood, critical-css-webpack-plugin will instantiate a headless Chrome using Puppeteer to access the landing page hosted by ddev in order to extact relevant critical css.

At that stage you should be able to view the landing page at `https://demo.ddev.site`.

You can see how the plugin is triggered by opening the `webpack.config.js` configuration file.

A `yarn dev` and `yarn watch` scripts are also provided as examples.

## Original Author: [@juban](https://github.com/juban)

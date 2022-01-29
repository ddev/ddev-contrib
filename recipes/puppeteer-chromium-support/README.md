# Puppeteer Chromium support

> ⚠️ That recipe has been updated to be compatible with latest ddev web container images (1.6 and upper) and Apple Silicon M1 architecture.

Npm packages like `codeceptjs` or `html-critical-webpack-plugin` which depend on [Puppeteer](https://github.com/puppeteer/puppeteer/) will not be able to launch the bundled chromium binary from within the web container because of some missing Linux libraries.

Furthermore, for now, the bundled chromium version will not run on Apple Silicon M1 architecture. This recipe provides a workaround to use a native chromium package instead of the one provided by Puppeteer.

You can add chromium support to your ddev project by adding the following extra Debian packages to your `config.yaml` file:

```yaml
webimage_extra_packages: [gconf-service, libasound2, libatk1.0-0, libcairo2, libgconf-2-4,
  libgdk-pixbuf2.0-0, libgtk-3-0, libnspr4, libpango-1.0-0, libpangocairo-1.0-0, libx11-xcb1,
  libxcomposite1, libxcursor1, libxdamage1, libxfixes3, libxi6, libxrandr2, libxrender1,
  libxss1, libxtst6, fonts-liberation, libappindicator1, libnss3, xdg-utils]
```

For Apple Silicon M1 support, you will have to override that configuration by adding a `config.m1.yaml` file in your ddev folder along with the `config.yaml` one with the following content:

```yaml
webimage_extra_packages : [chromium]
web_environment:
- CPPFLAGS=-DPNG_ARM_NEON_OPT=0
- PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium
- PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
```

## Puppeteer CSS Demo

You will find a proof of concept in the [demo](demo/) folder.

It is based on the [Tailwind CSS Landing Page starter project](https://github.com/tailwindtoolbox/Landing-Page) and demonstrate how to use [Webpack Encore](https://symfony.com/doc/current/frontend.html) to compile javascript and css resources and extract critical CSS with critical-css-webpack-plugin from within the ddev web container.

Obviously, the PHP part is quite minimalistic and is just used to read the webpack manifest file to inject relevant javascript and css files and inline the critical css file in the landing page. However, the overall workflow can easily be adapted in a more complex PHP project using a CMS or a framework.

> In order to run the demo project on Apple Silicon M1, rename the `config.m1.yaml.dist` to `config.m1.yaml` before starting ddev.

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

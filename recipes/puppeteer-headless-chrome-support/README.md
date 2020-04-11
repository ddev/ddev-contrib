# Puppeteer Headless Chrome support

Npm packages like codeceptjs or critical-css-webpack-plugin which depend on [Puppeteer](https://github.com/puppeteer/puppeteer/) will not be able to run from within the web container because of some missing Linux libraries.

You can add Puppeteer support by setting the following extra Debian packages to your ddev `config.yaml` file:

```yaml
webimage_extra_packages: [gconf-service, libasound2, libatk1.0-0, libcairo2, libgconf-2-4, libgdk-pixbuf2.0-0, libgtk-3-0, libnspr4, libpango-1.0-0, libpangocairo-1.0-0, libx11-xcb1, libxcomposite1, libxcursor1, libxdamage1, libxfixes3, libxi6, libxrandr2, libxrender1, libxss1, libxtst6, fonts-liberation, libappindicator1, libnss3, xdg-utils]
```

# Puppeteer Headless Chrome support

Npm packages like codeceptjs or critical-css-webpack-plugin which depend on [Puppeteer](https://github.com/puppeteer/puppeteer/) will not be able to run from within the web container because of some missing Linux libraries.

This [Dockerfile](Dockerfile) add all required dependencies in order to run the Headless Chrome provided by Puppeteer.

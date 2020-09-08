# Varnish

This recipe allows you to configure a Varnish reverse proxy for your project.

The Varnish service inserts itself between ddev-router and the web container, so that calls
to the web container are routed through Varnish first. The [docker-compose.varnish.yaml](docker-compose.varnish.yaml)
replaces the ```VIRTUAL_HOST``` variable of the web container with a subdomain of
the website URL (see below) and uses the default domain as its own host name.

To enable Varnish in your project follow these steps:

1. Copy [docker-compose.varnish.yaml](docker-compose.varnish.yaml) into your project's .ddev directory.
2. Create a directory named _varnish_ in your project's .ddev directory.
3. Copy the [default.vcl](default.vcl) in this directoy.
4. Run `ddev start`.
5. From now on calls to the web container (e.g. https://example.ddev.site) are
   routed through Varnish. If you would like to access the site without Varnish,
   simply prepend the URL with _novarnish._ (e.g. https://novarnish.example.ddev.site).

---

Based on the work of [rikwillems](https://github.com/rikwillems).

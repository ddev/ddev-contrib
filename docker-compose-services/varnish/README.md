# Varnish

This recipe allows you to configure a Varnish reverse proxy for your project.

1. Copy [docker-compose.varnish.yaml](docker-compose.varnish.yaml) into your project's .ddev directory.
2. Create a directory named _varnish_ in your project's .ddev directory.
3. Put a file named _default.vcl_ in this directoy.
4. `ddev start`

For a quick start you can use the put the following contents into _default.vcl_:

```
vcl 4.1;

backend default {
  .host = "web";
  .port = "80";
}
```

---

Based on the work of [rikwillems](https://github.com/rikwillems).

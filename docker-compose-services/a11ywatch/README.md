# A11yWatch

Using the A11yWatch container image [A11yWatch](https://hub.docker.com/r/a11ywatch/a11ywatch).

Run automated web accessibility audits at warp speed with vast coverage across issues and domains made with Rust.

## Installation

Copy [docker-compose.a11ywatch-standalone.yaml](docker-compose.a11ywatch-standalone.yaml) to your project's .ddev folder.

Optional: adjust env configurations with appropriate keys.
Optional: set `A11YWATCH_IMAGE` env variable to `darwin` or adjust the image name directly if on mac for improved performance non QEMU.

## Configuration

From within the container, the a11ywatch container is reached at hostname: "a11ywatch", port: 3280 and port: 50050 for gRPC so the server URL might be `http://a11ywatch:3280`. You can also use the "ddev.site" http and https urls to access it: `http://<projectname>.ddev.site:3280`, and `https://<projectname>.ddev.site:3280`

## Connection

You can access the [A11yWatch Lite](https://github.com/a11ywatch/a11ywatch) server directly from the host for debugging purposes by visiting `http://<projectname>.ddev.site:3280`. If you have SSL enabled, which is recommended, you can access A11yWatch via `https://<projectname>.ddev.site:3280`

## Additional Resources

* To get detailed infromation on how to interact or commincate with the [A11yWatch API Info](https://a11ywatch.com/api-info) A11yWatch.
* The [A11yWatch CLI](https://github.com/a11ywatch/a11ywatch) is helpful to perform automated task using the gRPC client.

**Contributed by [j-mendez](https://github.com/j-mendez)**

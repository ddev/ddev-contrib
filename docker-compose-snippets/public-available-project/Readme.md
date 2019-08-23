## Create public project without ngrok

Due to security reasons Drud has removed 0.0.0.0
from router. So your projects can not be accessed
directly by your FQDN anymore. Instead you should use ngrok,
which is a kind of proxy service. If you use ngrok for free
the subdomain changes with each restart of DDev, further you
are limited in your requests each minute and don't forget:
All traffic was send over ngrok and I don't know what they are
with these data.

That's why I have tried to get back the old behaviour of DDev to
create public projects again without ngrok.

After two days of work I have found a solution for me and maybe
it is working for you, too:

I have changed router ports in config.yaml of my projects to:

```
router_http_port: "8080"
router_https_port: "4433"
```

and added a subdomain to FQDN section:

```
additional_fqdns:
  - my-subdomain.my-domain.de
```

Then I have created a docker-compose.router.yaml and mapped the public ports
80 and 443 to the configured router ports of my config.yaml 8080 and 4433.
This file is a copy of ~/.ddev/router-compose.yaml (which will be re-created
with each start of router):

```
version: '3.6'
services:
  router:
    image: drud/ddev-router:v1.10.0
    container_name: router
    ports:
      - "0.0.0.0:80:8080"
      - "0.0.0.0:443:4433"
    volumes:
      - /var/run/docker.sock:/tmp/docker.sock:ro
      - ddev-global-cache:/mnt/ddev-global-cache:rw
    restart: "no"
    healthcheck:
      interval: 1s
      retries: 10
      start_period: 10s
      timeout: 120s

networks:
   default:
     external:
       name: ddev_default
volumes:
   ddev-global-cache:
     name: ddev-global-cache
```

Maybe it's needed to stop and remove ddev-router from docker:

```
docker stop ddev-router
docker rm ddev-router
```

With next DDev start I can access my subdomain without ngrok and without
any foreign ports like 32582 and my TYPO3 backend feels a little bit faster
than tunneled over ngrok.

And yes, I know, maybe the server is now open like a barn door again...so
please do not build this setup on productive.
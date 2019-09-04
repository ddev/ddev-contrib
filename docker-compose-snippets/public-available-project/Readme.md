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

### Additional information for multiple projects

The above example works for one project only. If you have more than one project
you will get an error that your router service already exists. In that case I prefer
to configure one little or dummy project with the router service from above. For
all other projects you only set the ports to 8080 and 4433. As ddev-router and our
own router are working on same volume, our router knows about all other projects, too.

1. Configure one little or dummy project with additional router service
2. Configure next project without router, but with port changes
3. Configure further projects the same way
4. You have to start your projects first, so that ddev-router can write configuration
to docker volume. Now our router should know the new configuration.
5. At last start your little dummy project with your own router service. Alternative
you also can start your router service with docker directly `docker start router`

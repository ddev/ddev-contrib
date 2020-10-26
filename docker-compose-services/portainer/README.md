# Portainer Service for DDEV

This recipe allows you to mount a new container in your ddev network with Portainer as new service.

Portainer is a visual mode for management of containers and networks. Is open-source tool that provides a [GUI](https://en.wikipedia.org/wiki/Graphical_user_interface) to facilitate the management of Dockerized environments and by extension, DDEV-based container networks.

* More about Portainer:
    * [Repo: github.com/portainer](https://github.com/portainer).
    * [Docs: portainer.io/documentation](https://www.portainer.io/documentation/).

## Installation and Use

1. Copy [docker-compose.portainer.yaml](docker-compose.portainer.yaml) into your project's .ddev directory.
2. Run `ddev start`.
3. Access to your Portainer Interface using the same project's name, through the ports assigned in the file (9000, 8000 by default), something like: projectname.ddev.site:9000.
4. Create the new admin user of the service writing down a secure password:
![DDEV Portainer Sign up](images/davidjguru_ddev_portainer_sign_up.png)

5. Access to the reports of your containers and perform actions on them:
![DDEV Portainer Get Report](images/davidjguru_ddev_portainer_get_report.png)

6. **Be aware!** Portainer gets data from the Docker socket in your system, so you'll get information about all the existing containers in your environment, so be careful with instructions given to containers, don't make a mistake.

## Connection

Ok, by default you can access to the Portainer interface at the next addresses from your browser:

```
# using http
http://projectname.ddev.site:9001
http://127.0.0.1:9001

# or using https
https://projectname.ddev.site:8001
https://127.0.0.1:8001
```
**Why?** Well, we're setting the mapped ports from Host to Guest just likes this:   

``` 
environment:
  HTTP_EXPOSE: "9001:9000"
  HTTPS_EXPOSE: "8001:9000"
```

If you want to avoid conflicts in the host side, just stop your DDEV-Local network, changing the value in the former section and relaunch the containers.  

Just do:  

```
$ ddev stop
$ vim docker-compose.portainer.yaml
    environment:
      HTTP_EXPOSE: "3401:9000"
      HTTPS_EXPOSE: "3501:9000"
  :wq!
$ ddev start
```

And remember that Portainer always exposes internally to the ddev network from its port 9000 in the container, so use this address as destiny in your mapping.  

**Contributed by [davidjguru](https://gitlab.com/davidjguru)**, [Drupal Developer](https://www.drupal.org/u/davidjguru) and blogger in [The Russian Lullaby](https://www.therussianlullaby.com/).

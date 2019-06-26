## Mounting a directory into web container

This simple [docker-compose.mount.yaml](docker-compose.mount.yaml) just mounts a directory from the host into the web container. 

Caveats:

* The source directory on the host must be shared via docker. 
* If the mount should be read-only in the container, add `:ro` to the mount 

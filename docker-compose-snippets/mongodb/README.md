## MongoDB

This simple [docker-compose.mongo.yaml](docker-compose.mongo.yaml) create 2 new containers, one for MongoDB and one for Mongo Express. 

Based on [MongoDb from Docker Hub](https://hub.docker.com/_/mongo?tab=description#-via-docker-stack-deploy-or-docker-compose) and [ddev custom compose files](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/)

It's a first try, contributions to improve it are welcome!

Caveats:

* mongo-express will be accessible from everyone on local network, you must use your firewall to avoid that.
* you can't define custom MongoDB configuration

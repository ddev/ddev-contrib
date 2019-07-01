## MongoDB

This simple  create 2 new containers, one for MongoDB and one for Mongo Express. 

Based on [MongoDb from Docker Hub](https://hub.docker.com/_/mongo?tab=description#-via-docker-stack-deploy-or-docker-compose), [ddev custom compose files](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/) and [API Platform tutorial](https://api-platform.com/docs/core/mongodb/#enabling-mongodb-support)

It's a first try, contributions to improve it are welcome!

I'm using it on a Symfony 4 app with API Platform.

Steps to follow:
- Install Php extension, see the [example .ddev/web-build/Dockerfile](Dockerfile).
- Add extra file [docker-compose.mongo.yaml](docker-compose.mongo.yaml)
- Require the [Doctrine MongoDB ODM bundle](https://github.com/doctrine/DoctrineMongoDBBundle)

`ddev composer req doctrine/mongodb-odm-bundle:^4.0.0@beta doctrine/mongodb-odm:^2.0.0@beta`
- In your application `.env`, set the connection string:
```
MONGODB_URL=mongodb://db:db@mongo:27017
MONGODB_DB=api
```

Mongo Express will be accessible from `<site>.ddev.site:8081`

Caveats:

* mongo-express will be accessible from everyone on local network, you must use your firewall to avoid that.
* you can't define custom MongoDB configuration
* you can't use `ddev import-db`

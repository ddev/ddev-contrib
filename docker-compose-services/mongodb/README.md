# MongoDB

This simple recipe creates two new containers, one for MongoDB and one for Mongo Express.

Based on [MongoDb from Docker Hub](https://hub.docker.com/_/mongo?tab=description#-via-docker-stack-deploy-or-docker-compose), [ddev custom compose files](https://ddev.readthedocs.io/en/stable/users/extend/custom-compose-files/) and [API Platform tutorial](https://api-platform.com/docs/core/mongodb/#enabling-mongodb-support).

I'm using it on a Symfony 4 app with API Platform.

Steps to follow:

1. Install php-mongo extension by adding `webimage_extra_packages: [php-mongodb]` to your .ddev/config.yaml.

2. Add extra file [docker-compose.mongo.yaml](docker-compose.mongo.yaml)

3. Require the [Doctrine MongoDB ODM bundle](https://github.com/doctrine/DoctrineMongoDBBundle)
    `ddev composer require doctrine/mongodb-odm-bundle:^4.0.0@beta doctrine/mongodb-odm:^2.0.0@beta`

4. In your application `.env`, set the connection string:

    ```
    MONGODB_URL=mongodb://db:db@mongo:27017
    MONGODB_DB=api
    ```

Mongo Express will now be accessible from `https://<site>.ddev.site:8081`

Caveats:

* You can't define custom MongoDB configuration with this current setup.
* You can't use `ddev import-db` to import to mongo.

**Contributed by [@wtfred](https://github.com/wtfred)**

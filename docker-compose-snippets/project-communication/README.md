## Communicating between two projects

There are many reasons to have two independent ddev projects talk with each other, and there are very easy ways to do it:

1. *Database*: If one project just needs to access the database server of the other (as in a Drupal migration, for example), it's super easy. Just use the full container name of the second project's db container as the hostname of the db server. For example, `ddev-project2-db`.
2. *Simple TCP or HTTP*: You can also just hit the web container of the second project via http or https, for example `curl http://ddev-project2-web` (https doesn't work at the time of this writing though)

What some people want, though, is a third option, *HTTP or HTTPS routed through ddev-router*. That's what this example demonstrates.

This [docker-compose.project2.yaml](docker-compose.project2.yaml) is intended to be put in project1/.ddev/, and  then it will be able to `curl https://project1.ddev.site`, or do anything else that's going through the router (http or https exposed ports)

### Resources

* [Stack Overflow question on communication between projects](https://stackoverflow.com/questions/51710272/communication-between-two-ddev-projects)
* [Migrating from Drupal 6 to Drupal 8 Like a Boss](https://dev.acquia.com/blog/migrating-drupal-6-drupal-8-boss) demonstrates option 1 in the context of a Drupal migration activity.

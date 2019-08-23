# Introduction
DDEV supports Drupal 8 multisite, however it is not always obvious what changes need to be done to make it work. Additionally, sometimes setup helpful for single-site configuration blocks the desired behavior for a multi-site setup.

This example will show how to setup a basic two-site multisite configuration, covering ddev, database, drush, and other issues. It has been tested on a Mac.

Neither of the sites will be default to ensure that if something is misconfigured, commands will fail against incomplete Drupal site instance instead of silently running against wrong one.

# Initial setup

Let's mostly follow the suggested configuration in [the official DDEV documentation for Drupal 8 setup](https://ddev.readthedocs.io/en/stable/users/cli-usage/#drupal-8-quickstart).
1. mkdir d8m
1. cd d8m
1. ddev config --project-type php
1. ddev composer create drupal-composer/drupal-project:8.x-dev --stability dev --no-interaction --prefer-dist
1. ddev config --project-type drupal8
1. ddev restart
1. ddev describe

This gets us to the basic Drupal 8 site using composer setup At this point, if you go to the assigned URL (http://d8m.ddev.site), you will see Drupal's site creation dialogue. Let's leave that as is and not configure the default site.

Let's create two sites: 

1. **basic** - using *standard* install profile
1. **umami** - using *umami* install profile

# Preparing the databases and URLs

The file *.ddev/config.yaml* is where additional URLs are setup and where we can use hooks to create the databases. However, it may be better to use [a separate override config file](https://ddev.readthedocs.io/en/stable/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files) to keep that information more clear and easier to track. The combination of sites may also be different on each individual machine, so this file may or may not be checked into the version control.

To setup the databases, we can add the command into the *post-start* hook. And the hostnames are declared in *additional_hostnames* options.

So, let's setup an *.ddev/config.multisite.yaml* with additional information for both of our sites. Notice that while it is possible to have multiple config files, they specific options override each other, not extend. So, it is not possible to have one extension config file per site.

1. Copy [example config.multisite.yaml](dot.ddev/config.multisite.yaml) to your setup's .ddev directory.
1. ddev restart

You should get a message that additional domains are now available:

> Your project can be reached at https://basic.ddev.site https://d8m.ddev.site https://umami.ddev.site https://127.0.0.1:32817

# Preparing drush
Drush is useful, but it is a bit annoying to *ddev ssh* into the container all the time or to run *ddev exec drush*. Fortunately, latest version of DDEV already ships with a simpler way, using [Container commands](https://ddev.readthedocs.io/en/stable/users/extend/custom-commands/).  And drush is one of the examples, so it just needs to be renamed.

1. mv .ddev/commands/web/drush.example .ddev/commands/web/drush
1. ddev drush status

# Enabling multisite

First we need to enable the multisite support by copying *example.sites.php* to *sites.php*. And then, because we are using DDEV for development and our production URLs will be different from test URLs, we want to define explicit aliases. That also allows us to have nice site directory names. 

1. cd *web/sites*
1. mkdir *basic* *umami*
1. cp *example.sites.php* *sites.php*
1. add aliases to *sites.php* to point *sitename*.ddev.site to *sitename* directory
1. Remove all the commented out lines, as we still kept original example
1. If you know production URL, you can add them at the same time

The final *sites.php* should look something like the [example inluded](web/sites/sites.php).

# Disabling DDEV's global drush option
Now, we have to do a DDEV specific thing. Trying to be helpful, it creates a global drush configuration file that sets *uri* option for the default project url. [This is not recommended](https://github.com/drush-ops/drush/blob/e8d0fdc32e5457cbcd0b63b8c897fb2a6496c9d6/examples/example.drush.yml#L85-L87) for multisite configuration as it may confuse drush into silently using wrong site.

So, we want to disable that option. However, the file is DDEV generated, so we can't just comment the line out, it may get regenerated. We need to remove the auto-generation marker lines as well. We can make this file empty.

1. Edit *web/sites/all/drush/drush.yml* and delete all content including comments
1. Explicitly checkin the file into git, if using (it has to be explicit, as DDEV also creates a local *.gitignore* file)


# Preparing umami site
Normally, with multisite install, a *settings.php* file is copied from *default* directory. However, DDEV adds its own parallel config file (*settings.ddev.php*). As that ddev file is also auto-managed, just copying it may cause problems later. One of the things it includes is database configuration, so we can't just ignore it. And we also can't just copy *settings.php*, as the inclusion statement is site local and it will not find the additional file back in *default* directory.

For this example, we are just going to include both *settings.php* and *settings.ddev.php* by direct reference and then override some values ([see example](web/sites/umami/settings.php)). The best solution may look a bit different.

1. cd *web/sites/umami*
1. create *settings.php*
1. Edit the file to directly include both *default/settings.php* and *default/settings.ddev.php* (if present)
1. Add override option for default database name, as we gave default *db* user access to all our databases. This keeps things simpler.

Now, if *drush status* is run from within *web* container's *umami* directory, the output should look similar to following:

    Drupal version : 8.7.6
    Site URI       : http://umami
    DB driver      : mysql
    DB hostname    : db
    DB port        : 3306
    DB username    : db
    DB name        : umami
    PHP binary     : /usr/bin/php7.2
    PHP config     : /etc/php/7.2/cli/php.ini
    PHP OS         : Linux
    Drush script   : /usr/local/bin/drush
    Drush version  : 9.7.1
    Drush temp     : /tmp
    Drush configs  : /var/www/html/vendor/drush/drush/drush.yml
                     /var/www/html/drush/drush.yml
                     /var/www/html/web/sites/all/drush/drush.yml
    Drupal root    : /var/www/html/web
    Site path      : sites/umami

If *Site path* looks different or DB information is missing, that means something has gone wrong.

Note that this has be run from inside the container and not from outside with *ddev drush* as drush needs to know which site we are referencing. This will be fixed once we have drush aliases in place.

# Creating umami site

Now, visiting http://umami.ddev.site will show the site creation form. Going through the form and setting the values and defaults (including *Demo: Umami* profile) will create the Umami Food Magazine site.

Notice that visiting either http://basic.ddev.site or http://d8m.ddev.site still shows the site creation form. 

And reruning *drush status* inside the *umami* directory within the *web* container should now show additional information from the initialized site.

# Creating basic site

We can follow the same steps for the basic site. We already have the directory, URL, database, and *sites.php* setup. So all that needs to be done is:

1. Copy *settings.php* from *umami* directory and change database name to *basic*.
1. Visit http://basic.ddev.site and setup the site with *Standard* profile

Now, we have a simple Drupal site at http://basic.ddev.site, a food magazine at http://umami.ddev.site and still only a configuration form at the original http://d8m.ddev.site. 

# Setting up drush site aliases

[Drush site aliases](http://docs.drush.org/en/9.x/usage/#site-aliases) help to address individual sites without being in the specific directory inside the web container. There is an example *self.site.yml* already with *drush/sites* folder, showing the basic format for default (self) site with environments *prod* and *stage*.

Let's also use an environment name *ddev* for our local setup. We only need to set *root* and *uri* parameters to point to the Drupal root (within container) and the full url to the site instance.

1. cd *drush/sites*
1. cp *self.site.yml* [umami.site.yml](drush/sites/umami.site.yml)
1. Edit *umami.site.yml* to have *ddev* environment and two options:
   * root: /var/www/html/web (for default ddev Drupal setup)
   * uri: http://umami.ddev.site
1. Run *ddev drush site:alias* from outside of the container to check that the alias is recognized
1. Run *ddev drush @umami.ddev status* to check that all site-specific information is now present, including full *Site URI*
1. Copy *umami.site.yml* to *basic.site.yml* and update *uri* option (*root* option does not change)
1. Run *ddev drush @basic.ddev status* to check alias working for the second site too
1. Run *ddev drush status* to remind what the default configuration still shows
1. Run *ddev drush views:list* to see the kind of error shown if the site alias is accidentally forgotten

# Adding more sites
Now that we have a basic setup in place, new site requires:

1. Updating [config.multisite.yaml](dot.ddev/config.multisite.yaml) to add the database and set the website address (remember to run *ddev restart* to pick up the changes)
1. Creating a directory for the new site
1. Copying *settings.php* to the new directory and updating the database name
1. Adding new alias to the *sites.php* 
1. Copying a drush alias and updating the *uri* option
1. Visiting the new site and complete the Drupal setup

# Conclusion
There is a lot more work to setup a good Drupal site. *settings.php* file alone may need a lot more additional configuration. This however, is a standard Drupal issue covered in their documentation.

The focus of this example was to show how to get the basics working within the DDEV environment. Hopefully, things are clearer now.
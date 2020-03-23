# DDEV-Local Drupal 8 Multisite Recipe

DDEV supports Drupal 8 multisite, however it is not always obvious what changes need to be done to make it work. Additionally, sometimes setup helpful for single-site configuration blocks the desired behavior for a multi-site setup.

This example will show how to setup a basic two-site multisite configuration, covering ddev, database, drush, and other issues. It has been tested on macOS, but should work anywhere.

Neither of the sites will be default to ensure that if something is misconfigured, commands will fail against incomplete Drupal site instance instead of silently running against wrong one.

## Initial DDEV-Local and Drupal 8 setup

Let's mostly follow the suggested configuration in [the official DDEV documentation for Drupal 8 setup](https://ddev.readthedocs.io/en/stable/users/cli-usage/#drupal-8-quickstart).

```
mkdir d8m
cd d8m
ddev config --project-type=drupal8 --docroot=web --create-docroot --disable-settings-management
ddev composer create drupal/recommended-project
ddev composer remove drupal/core-project-message
ddev composer require drush/drush
ddev restart
ddev describe
```

Note that we used `--disable-settings-management` with `ddev config`. THis prevents ddev from trying to be helpful by creating settings files for Drupal or drush. But it means that we are completely in charge of our settings files.

This gets us to the basic Drupal 8 site using composer setup At this point, if you go to the assigned URL (<https://d8m.ddev.site),> you will see Drupal's site creation dialogue. Let's leave that as is and not configure the default site.

Let's create two sites:

* **basic** - using *standard* install profile
* **umami** - using *umami* install profile

## Prepare the databases and URLs

The file `.ddev/config.yaml` is where additional URLs are setup and where we can use hooks to create the databases. However, it may be better to use [a separate override config file](https://ddev.readthedocs.io/en/stable/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files) to keep that information more clear and easier to track. The combination of sites may also be different on each individual machine, so this file may or may not be checked into the version control.

To setup the databases, we can add the command into the *post-start* hook. And the hostnames are declared in *additional_hostnames* options.

So, let's setup an `.ddev/config.multisite.yaml` with additional information for both of our sites. Notice that while it is possible to have multiple config files, they specific options override each other, not extend. So, it is not possible to have one extension config file per site.

1. Copy [example config.multisite.yaml](dot.ddev/config.multisite.yaml) to your setup's .ddev directory.
2. ddev restart

You should get a message that additional domains are now available:

> Your project can be reached at <https://basic.ddev.site> <https://d8m.ddev.site> <https://umami.ddev.site> <https://127.0.0.1:32817>

## Enable multisite

First we need to enable the multisite support by copying `example.sites.php` to `sites.php`. And then, because we are using DDEV for development and our production URLs will be different from test URLs, we want to define explicit aliases. That also allows us to have nice site directory names.

    ```
    cd web/sites
    mkdir basic umami
    cp example.sites.php sites.php
    ```

1. Configure sites in the sites.php to match the URL with the correct directory.
2. If you know the production URLs, you can add them at the same time.

The final `sites.php` should look something like the [example included](web/sites/sites.php).

## Provide a base settings.base.php

Since the settings.php for each subsite is nearly the same, we can use a basic settings file and include it in each subsite. The example provided here is [web/sites/default/settings.base.php](web/sites/default/settings.base.php). Copy that into the `web/sites/default` directory of your project.

## Prepare example umami site

Inspect  [web/sites/umami/settings.php](web/sites/umami/settings.php) and copy it to `web/sites/umami`.

Now, if `drush status -l umami.ddev.site` is run from within the *web* container's `sites/umami` directory, the output should look similar to following:

```
web/sites/umami$ $ drush status -l umami.ddev.site
Drupal version : 8.8.4
Site URI       : http://umami.ddev.site
DB driver      : mysql
DB port        :
DB username    : db
DB name        : umami
PHP binary     : /usr/bin/php7.3
PHP config     : /etc/php/7.3/cli/php.ini
PHP OS         : Linux
Drush script   : /usr/local/bin/drush
Drush version  : 10.2.2
Drush temp     : /tmp
Drush configs  : /var/www/html/vendor/drush/drush/drush.yml
Drupal root    : /var/www/html/web
Site path      : sites/umami
```

If *Site path* looks different or DB information is missing, that means something has gone wrong.

## Install the umami demo site

Now, visiting <https://umami.ddev.site> will show the site creation form. Going through the form and setting the values and defaults (including *Demo: Umami* profile) will create the Umami Food Magazine site.

Notice that visiting either <https://basic.ddev.site> or <https://d8m.ddev.site> still shows the site creation form.

And reruning `drush status` inside the `sites/umami` directory inside the *web* container should now show additional information from the initialized site.

## Install the "basic" demo site

We can follow the same steps as we did for "umami" for the "basic"" site. We already have the directory, URL, database, and `sites.php` setup. So all that needs to be done is:

1. Inspect  [web/sites/basic/settings.php](web/sites/basic/settings.php) and copy it to `web/sites/basic`.
2. Visit `https://basic.ddev.site` and install the site with the *Standard* profile

Now, we have a simple Drupal site at <https://basic.ddev.site,> a food magazine at <https://umami.ddev.site> and still only a configuration form at the original <https://d8m.ddev.site.>

## Set up drush site aliases

[Drush site aliases](http://docs.drush.org/en/9.x/usage/#site-aliases) help to address individual sites without being in the specific directory inside the web container.

We'll set the *root* and *uri* parameters to point to the Drupal root (within container) and the full url to the site instance.

1. `mkdir -p drush/sites && cd drush/sites`
2. Inspect and copy the sample aliases files in [drush/sites](drush/sites) into your project's drush/sites directory.
3. Run `ddev exec drush site:alias` from outside the container to check that the alias is recognized
4. Run `ddev exec drush @umami.ddev status` to check that all site-specific information is now present, including full *Site URI*
5. Run `ddev exec drush @basic.ddev status` to check that the alias is working for the second site too.
6. Run `ddev exec drush status` to see what the default configuration still shows.

## Add more sites

Now that we have a basic setup in place, new site requires us to:

1. Update ddev's [config.multisite.yaml](dot.ddev/config.multisite.yaml) to add the database and set the additional_hostnames (remember to run `ddev restart` to pick up the changes). This can also be done directly in the .ddev/config.yaml.
2. Create a directory for the new site in `web/sites/<newsitename>`.
3. Copy `settings.php` to the new directory and update the database name.
4. Add new alias to the `sites.php`.
5. Copy a drush alias and updating the `uri` option.
6. Visit each new site to install Drupal.

## Conclusion

Of course much more work lies ahead.  The `settings.php` file alone may need a lot more additional configuration. This however, is a standard Drupal issue covered in Drupal's documentation.

The focus of this example was to show how to get the basics working within the DDEV-Local environment.

**Contributed by [@arafalov](https://github.com/arafalov)**

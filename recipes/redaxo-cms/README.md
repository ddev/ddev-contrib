# Install [REDAXO CMS](https://redaxo.org) with DDEV

## What is REDAXO

[REDAXO](https://redaxo.org) is an open source content managment system devleoped by the German web agency  [Yakamara](https://www.yakamara.de/).

REDAXO is for people who love the flexibility of a content managment system; you have easy control of your code and also of the content that you want to create.

## Install REDAXO code and submodules

In general, REDAXO setup is exactly the same as any other generic PHP project, except for the need to update the git submodules after cloning.

* Clone the REDAXO repository: `git clone https://github.com/redaxo/redaxo.git`
* Update  git submodules: `git submodule init && git submodule update`

## Configure ddev

* Use `ddev config --project-type=php --webserver-type=apache-fpm` to configure the project. REDAXO expects an apache webserver; `php` is the default/generic project type.

## Start ddev and visit the REDAXO URL to configure the project

* `ddev start`
* Visit the selected URL (like `https://redaxo.ddev.site`) to choose language, license terms, etc.
* Configure site and database settings. (Database name is `db`, mysql host is `db`, database username is `db`, and password is `db`)
* Complete setup
* To see complete ddev project information, use `ddev describe`.

## Original Author: [@simonwestghost](https://twitter.com/simonwestghost)

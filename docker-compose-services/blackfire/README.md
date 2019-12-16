# Blackfire.io Integration for DDEV-Local

Blackfire.io is a profiler for PHP sites, it will help you find out what your code is doing, showing where most of the execution time is spent. It's a successor or competitor to older profiling tools like XHProf. It consists of three parts:

- the probe (Already installed in ddev by default)
- the agent (Added as an additional service in docker-compose.blackfire.yaml)
- the client (Installed and configured by you on your host, or any computer)

## The Probe

The probe is a PHP module which is already installed on a default DDEV setup.

## The Agent

The agent is provided as docker image by blackfire. Add it to your setup via the provided [docker-compose.blackfire.yaml](docker-compose.blackfire.yaml). Make sure to edit the `BLACKFIRE_SERVER_ID` and `BLACKFIRE_SERVER_TOKEN` environment variables set there.

To make sure the probe and agent can communicate, you must override
the blackfire agent socket in a custom PHP config file ([docs](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#providing-custom-php-configuration-phpini)). Place the provided [php/blackfire.ini](php/blackfire.ini) in .ddev/php and will work fine; it contains`blackfire.agent_socket = tcp://blackfire:8707`

## The Client

* To use the command-line client, download it for your host platform via the blackfire.io website (see [installation instructions](https://blackfire.io/docs/up-and-running/installation#installation-instructions) for the client for each platform). For basic command-line blackfire.io usage see [the blackfire.io docs](https://blackfire.io/docs/cookbooks/profiling-http). For example, `blackfire curl https://d8git.ddev.site` provides a link to a call graph of the functions which were called to build the page.
* To use the Google Chrome extension, see [blackfire chrome integration](https://blackfire.io/docs/integrations/chrome) and install the Chrome extension.
* There's also a [firefox extension](https://blackfire.io/docs/integrations/firefox) and of course Blackfire.io is capable of many other things.

## Basic Usage

* Make sure the server information is configured in the docker-compose.blackfire.yaml
* Make sure your blackfire client is configured with client keys.
* Start your configured project with `ddev start`
* Use `blackfire curl <project_url>` to get a call graph URL
* Use the Google Chrome extension on a specific page to get a call graph interactively.

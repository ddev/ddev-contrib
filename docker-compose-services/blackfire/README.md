# Blackfire.io Integration for DDEV-Local

Blackfire.io is a profiler for PHP sites, it will help you find out what your code is doing, showing where most of the execution time is spent. It's a successor or competitor to older profiling tools like XHProf. It consists of three parts:

1. the probe (Already installed in ddev by default)
2. the agent (Added as an additional service in docker-compose.blackfire.yaml)
3. the client (Installed and configured by you on your host, on the ddev web container, or any computer)

## The Probe

The probe is a PHP module which is already installed on a default DDEV setup.

## The Agent

The agent is provided as docker image by blackfire. Add it to your setup via the provided [docker-compose.blackfire.yaml](docker-compose.blackfire.yaml). Make sure to edit the `BLACKFIRE_SERVER_ID` and `BLACKFIRE_SERVER_TOKEN` environment variables set there.

To make sure the probe and agent can communicate, you must override
the blackfire agent socket in a custom PHP config file ([docs](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#providing-custom-php-configuration-phpini)). Place the provided [php/blackfire.ini](php/blackfire.ini) in .ddev/php and will work fine; it contains`blackfire.agent_socket = tcp://blackfire:8707`

## The Client

* To use the command-line client, download it for your host platform via the blackfire.io website (see [installation instructions](https://blackfire.io/docs/up-and-running/installation#installation-instructions)
  for the client for each platform). For basic command-line blackfire.io usage see [the blackfire.io docs](https://blackfire.io/docs/cookbooks/profiling-http).
  For example, `blackfire curl https://d8git.ddev.site` provides a link to a call graph of the functions which were called to build the page.
* To use the Google Chrome extension, see [blackfire chrome integration](https://blackfire.io/docs/integrations/chrome) and install the Chrome extension.
* There's also a [firefox extension](https://blackfire.io/docs/integrations/firefox) and of course Blackfire.io is capable of many other things.

## Basic Usage

* Make sure the server information is configured in the docker-compose.blackfire.yaml
* Make sure your blackfire client is configured with client keys.
* Start your configured project with `ddev start`
* Use `blackfire curl <project_url>` to get a call graph URL
* Use the Google Chrome extension on a specific page to get a call graph interactively.

## CLI client particulars

When you want to use the cli client, there are several ways to use it. There is no real difference between the container-based approaches, but the command you need to type in differ. Pick the approach that suits best your needs.

### Configure blackfire before use

Before you can use the cli client, you need to configure it with the client credentials blackfire.io provides for the used account.
You will find those at [the credentials page](https://blackfire.io/my/settings/credentials) after logging into your blackfire.io account.
Run `blackfire config`, which will ask for your Client ID and Client Token values. This works for each of the following usage versions, only the prefix you use will differ depending on the recipient.

### On your host system

This is the most straightforward approach. but requires changes on your
local host system. You might even run into conflicts, if the locally configures blackfire.io account is not
the same as the one you want to use to profile the project you use ddev for. If there are no concerns, just use this approach.

### From the DDEV web container

If you'd like to profile drush or other CLI commands running in your DDEV project, you'll need to add the blackfire client (agent) to your web container, using `webimage_extra_packages: [blackfire-agent]` in `.ddev/config.yaml`.
To test (after starting / restarting ddev on your project) the package has actually been installed, run `ddev exec blackfire`. 

The output should present the usage options of the blackfire.io cli client. Before running commands, you'll need to follow the "Configure blackfire before use" steps above, i.e., `ddev exec blackfire config`.

Here is an example of profiling a drush command using blackfire:

```bash
ddev exec blackfire run drush status
```

### From the blackfire container

This container is available from your setup, and the blackfire executable is already there, but the usage is a little awkward. Run

`ddev exec -s blackfire blackfire`
or `ddev ssh -s blackfire` and then use the blackfire command.

to see the usage help.

(The first ``blackfire`` in the command is the name of the container, the second one the actual command. Keep that in mind while using.)

### Troubleshooting

If using curl for profiling, provide the -L flag, like `blackfire curl -L https://my-project.ddev.site/typo3`

This will actually give you the TYPO3 backend you want to profile. If Location Header is not sent, you end up with
`Are you authorized to profile this page? No probe response, missing PHP extension or invalid signature for relaying agent.`

This is not helpful at all in discovering the source of your issue.
Here is a quick test: `blackfire curl https://my-project.ddev.site/typo3/` (no -L flag, but a trailing slash to the URL) will give you a profile,
when only the Location Header redirect is missing.

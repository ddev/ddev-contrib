## Blackfire.io Integration for DDEV-Local

Blackfire.io is a profiler for PHP sites, it will help you find out what your code is doing, showing where most of the execution time is spent. It's a successor or competitor to older profiling tools like XHProf. It consists of three parts:

- the probe (Already installed in ddev by default)
- the agent (Added as an additional service in docker-compose.blackfire.yaml)
- the client (Installed and configured by you on your host, or any computer)

### The Probe

The probe is a PHP module which is already installed on a default DDEV setup.

### The Agent

The agent is provided as docker image by blackfire. Add it to your setup via the provided [docker-compose.blackfire.yaml](docker-compose.blackfire.yaml). Make sure to edit the `BLACKFIRE_SERVER_ID` and `BLACKFIRE_SERVER_TOKEN` environment variables set there.

To make sure the probe and agent can communicate, adjust the blackfire agent socket via the provided [php/blackfire.ini](php/blackfire.ini), which contains: 

`blackfire.agent_socket = tcp://blackfire:8707`

### The Client

* To use the command-line client, download it for your host platform via the blackfire.io website (see [installation instructions](https://blackfire.io/docs/up-and-running/installation#installation-instructions) for the client for each platform). For basic command-line blackfire.io usage see [the blackfire.io docs](https://blackfire.io/docs/cookbooks/profiling-http). For example, `blackfire curl https://d8git.ddev.site` provides a link to a call graph of the functions which were called to build the page.
* To use the Google Chrome extension, [blackfire chrome integration](https://blackfire.io/docs/integrations/chrome) and install the Chrome extension.


### Basic Usage

 or for chrome-driven use, see [blackfire chrome integration](https://blackfire.io/docs/integrations/chrome)

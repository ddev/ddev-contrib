## Blackfire.io & ddev

Blackfire.io consists of three parts:

- the agent
- the probe
- the client

### The Probe

The probe is a PHP module which is already installed on a default DDEV setup.


### The Agent

The agent is provided as docker image by blackfire. Add it to your setup via `docker-compose.blackfire.yaml`.

To make sure the probe and agent can communicate, adjust the blackfire agent socket via `php/php.ini`: 

`blackfire.agent_socket = tcp://blackfire:8707`

### The Client

The client needs to be downloaded via the blackfire.io website (for example https://blackfire.io/docs/up-and-running/installation#install-cli-windows for the Windows version).


# Dynamically enable / disable a service

Have you ever wanted to enable a serivce locally, but not on you CI?
Need to quickly disable a service for debugging?

This handle little command lets you enable/disable a DDEV `docker-compose` based service.

## Installation

- Copy the `service` file into the DDEV commands directory.

To activate the command for all DDEV projects, copy it to your global DDEV config directory: `~/.ddev/commands/host`.

If you prefer to enable it on a per-project basis, copy it into the project commands directory: `./.ddev/commands/host`.

Note: If you have a copy in both locations, you will recieve a warning:

```shell
Project-level command 'service' is overriding the global 'service' command
```

## Usage

EG. Lets assume you have  `./.ddev/docker-compose.cypress.yaml` file that provides the `cypress` service.

Type the following command to disable the service:

```shell
ddev service cypress disable
ddev restart
```

The file is renamed to `./.ddev/docker-compose.cypress.yaml.disabled`. It will no longer be read by DDEV on startup.

Type the following command to enable the service:

```shell
ddev service cypress enable
ddev restart
```

## Notes

- The service name is parsed from the file name; `docker-composer.goo.yaml` assumes the service is called `goo`.
- You can update the command variable `DISABLED_EXT` to change the disabled extension. Default is ".`disabled`"

**Contributed by [@tyler36](https://github.com/tyler36)**

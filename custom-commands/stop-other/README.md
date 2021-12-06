# Stops all running projects except the current.

Copy the [stop-other](./stop-other) command to the .ddev/commands/host/ directory or the global ~/.ddev/commands/host directory (to make it work for all projects).

Now you can run `ddev stop-other` to stop all running projects except the one you are calling the command from.

This requires that the `jq` command be installed. `brew install jq` or see https://stedolan.github.io/jq/download/

**Original idea by sceo (on Discord) and code by [@rfay](https://github.com/rfay)**


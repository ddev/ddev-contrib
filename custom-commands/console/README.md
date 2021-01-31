# Run Symfony console commands (ddev console)

This adds custom command which executes the `bin/console` in the container without the need to SSH.

## Installation

- Copy the [web/](web/) directory into your project `.ddev/commands/web`, so that the [console](web/console) command would be in `.ddev/commands/web` folder.

- If the Symfony project is in a subfolder, add to `.ddev/ddev.config.yaml`:
  ```yaml
  working_dir:
    web: /var/www/html/<symfony-project-subfolder>
  ```

## Usage

Running `ddev console` is now equivalent to running `bin/console` from inside the container. It is now possible to get debug information such as `ddev console debug:router` or running a maker with `ddev console make:entity` without the need to SSH into the container.

## Example

> This is how `ddev console about` would look like:

![console](console-about-example.png)

**Contributed by [@alechko](https://github.com/alechko)**

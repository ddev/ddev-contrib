# Using Colima instead of Docker Desktop on macOS

[Colima](https://github.com/abiosoft/colima) is an alternative runtime to Docker Desktop with a permissive license. Colima is built on top of [Lima](https://github.com/lima-vm/lima) which is a more general virtual machine application.

Reasons to use Colima include:

- Preferring to use open-source software (Docker Desktop, unlike Docker, is proprietary software).
- Working for an organization that due to its size requires a paid Docker plan to use Docker Desktop, and wanting to avoid that cost and business relationship.
- Preferring a CLI-focused approach to Docker Desktop's GUI focus.

In day-to-day use, Colima is very similar to how WSL2 works on Windows.

## Using Colima with DDEV

1. Follow the [instructions to install Colima](https://github.com/abiosoft/colima#installation). Colima is in homebrew which is also a requirement for ddev.
1. If not already installed, install the Docker command line tools on macOS with `brew install docker`.
1. Run `colima start` to create the VM. For typical DDEV projects, it is recommended to use `colima start --cpu 4 --memory 4 --disk 100` as minimums to allow for 4 virtual CPUs, 4GB of memory, and 100GB of disk space.
  - This first boot will take some time, as it will download an Ubuntu disk image, and then install docker within it. Generally this is only done once.
1. If Docker Desktop is installed or running, by default command line tools will connect to it instead of Colima. Running `docker context use colima` will switch the active connection. Use `docker context ls` to see all available contexts.
1. Run `docker version` to verify everything is working correctly. Both client and server information should be shown.
1. Run `ddev config global --mutagen-enabled=true` to enable Mutagen syncing of code. By default, colima mounts are **read only** and very slow.
1. Run `ddev start` like normal in the projects of your choice.
1. Run `colima stop` to completely shut down the VM. This is equivalent to quitting Docker Desktop.
- When starting your day, `colima start && ddev start` will start colima and your project all at once.
- There is no need to run `ddev stop` before running `colima stop`.

## Alternative configurations

- Instead of using Mutagen, colima can be started with the `--mount` flag, such as with `--mount $HOME/projects:w` to mount the projects folder in your home directory read-write. However, colima currently uses sshfs for mounts and this is not suitable for many or most PHP or Node projects.
- DDEV can also be installed _inside_ the virtual machine. This is identical to how WSL2 installations are managed. A notable limitation is that ddev cannot install TLS certificates from `mkcert` in macOS browsers. Consider this setup experimental, such as for testing out PHPStorm's new remote develompment features.

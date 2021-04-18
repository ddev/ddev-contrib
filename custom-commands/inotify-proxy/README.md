# inotify-proxy to enable file watchers on NFS shares

On a regular Linux or macOS filesystem, a process can subscribe to notifications about file changes ("inotify" or "fsnotify").  Most IDEs like PhpStorm depend on this notification to update files or rendering when they change. However, the NFS protocol predates the inotify feature, and so does not support it. However, most developers on macOS and Windows use the [nfs_mount_enabled feature](https://ddev.readthedocs.io/en/stable/users/performance/#using-nfs-to-mount-the-project-into-the-web-container) to mount files from the host into the container instead of using the docker-native technique. Performance is much improved, but of course NFS does not support notifications.

(Note that this is not necessary on Linux hosts; NFS is not needed there because the Docker filesystem mount is so fast.)
This tool helps to detect changed files in Docker Containers if NFS mount is used.
If a file is changed from host system a file watcher inside the container detects the change and triggers a notify event. The command runs inside the docker container.

The tool is designed to run over a longer period of time. It comes with a garbage collector to cleanup old watched files in memory.

The command will download the pre-compiled binary inotify-proxy from Github release page and executes it.

The tool can be configured to watch only for files with defined extensions in configured directories.
See https://github.com/cmuench/inotify-proxy#config for informations about the configuration format.

## Installation

Copy the file `inotify` into your project **.ddev/commands/web** directory.

## Run the command

```sh
ddev inotify
```

**Contributed by [@cmuench](https://github.com/cmuench)**

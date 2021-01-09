# inotify-proxy to enable file watchers on NFS shares

This tools helps to detect changed files in Docker Containers if NFS mound is used.
If a file is changed from host system a file watcher inside the container detects the change and triggers an notify event.

The tool is designed to run over a longer period of time. It comes with a garbage collector to cleanup old watched files in memory.

The command will download the pre-compiled binary inotify-proxy from Github release page and executes it.

The tool can be configured to watch only for files with defined extensions in configured directories.
See https://github.com/cmuench/inotify-proxy#config for informations about the configuration format.

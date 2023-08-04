# Adding a "real" sshd server to web container

There's also a recent add-on for this with a more robust approach.

https://github.com/hanoii/ddev-sshd

----

Although most people do fine with `ddev ssh` and `ddev exec`, they don't actually use ssh, but are wrappers on `docker exec`. In the vast majority of cases, you don't need anything like this, but if you have an application that needs to *actually* use the real ssh protocols to access the web container, this recipe is for you.

1. Copy [config.sshd.yaml](config.sshd.yaml) and [docker-compose.sshd.yaml](docker-compose.sshd.yaml) into your project's .ddev folder. (Note that you can also incorporate the contents of config.ssshd.yaml into your config.yaml.)
2. Authorize your ssh client to access the web container's ssh server by adding a global `~/.ddev/homeadditions/.ssh/authorized_keys`, which will be copied into the ~/.ssh directory in the web container. The easiest way to do this, assuming your ssh pubkey is ~/.ssh/id_rsa.pub, is
    ```
    mkdir -p ~/.ddev/homeadditions/.ssh
    cp ~/.ssh/id_rsa.pub ~/.ddev/homeadditions/.ssh/authorized_keys
    ```
   (You can also create the authorized_keys file in the project `.ddev/homeadditions/.ssh` folder on a project by project basis but this command takes care of authorized_keys for all of your projects at once and can be executed from any directory.)
3. `ddev restart`
4. Access the web container with `ssh -p 2222 -o StrictHostKeyChecking=no localhost`

(The StrictHostKeyChecking=no is required because every time you restart the container it comes up with a new "host" identity.)

* Note: If you are running DDEV from a domain connected Windows PC, you may need to specify a username.

1. First, check if your account is tied to a domain. From a command prompt, type `whoami`

```shell
> whoami
work\user13
```

The above shows the current user `user13` is connected to the `work` domain.

2. If your account is tied to a domain, as above, you need to specify a username when connecting:  `<username>@localhost`, replace username with your user (Eg. user13);

```shell
ssh -p 2222 -o StrictHostKeyChecking=no <username>@localhost
```

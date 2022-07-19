# Using ddev behind a corporate web proxy (obsolete)

**This recipe is now obsolete. Please use [ddev get drud/ddev-proxy-support](https://github.com/drud/ddev-proxy-support)**

Some of us have to live with web proxies for access to the internet. There are loads of implications of this. Web browsers are great with proxies, as they've had to deal with them from the beginning of web browsing. But in a complex container environment there are loads of other things to think about, including curl, apt-get, docker containers, etc.

There are 4 basic things that need to work in a behind-proxy ddev environment:

1. The host needs to be configured to work. Of course if you're already working in a proxied environment you already know how to do this. Typically it's set up in the OS settings, and then the browsers are configured to use the system proxy settings. curl typically respects HTTP_PROXY and HTTPS_PROXY, and wget will respect http_proxy, etc.

2. The docker server needs to be configured via either:

    * The "proxies" section of the Docker Desktop application (on Windows or macOS) or
    * by creating an `/etc/systemd/system/docker.service.d/http-proxy.conf` file on Linux -
    [see Docker docs](https://docs.docker.com/config/daemon/systemd/#httphttps-proxy) . This will allow actions like `docker pull` to work correctly using the proxy. See [example http-proxy.conf](http-proxy.conf).

    If you use the first approach, you need to set the "http proxy server" and "https proxy server" to point to your proxy, and add "127.0.0.1" to the proxy bypass settings in Docker Desktop (Settings -> Resources -> Proxies).

    Example:

    * Web Server (HTTP) : `http://proxy:8888`
    * Secure Web Server (HTTPS) : `http://proxy:8888`
    * Bypass proxy settings for these hosts & domains: `127.0.0.1`

3. Normally, on Windows and macOS, the settings above will be reflected in ~/.docker/config.json, but if not they can be added there as shown in [Docker docs](https://docs.docker.com/network/proxy/). Again, you need to add the HTTP and HTTPS proxyes, and add ``"noProxy": 127.0.0.1`.

4. Individual images may need to be set up to make apt work inside them. This is optional, because if you do your apt-get work at container build time (in a .ddev/web-build/Dockerfile) then everything works using the host configuration. See the [example .ddev/web-build/Dockerfile](Dockerfile).

## Lab-testing a proxied environment

I used Parallels on macOS for the test lab.

* Created a Parallels VM proxy server with a simple tiny Ubuntu 18.04 server running [tinyproxy](https://tinyproxy.github.io/), which was shockingly simple to install and configure (`apt-get install tinyproxy`), very small configuration changes ([example /etc/tinyproxy/tinyproxy.conf](tinyproxy.conf)). I'll call this machine "proxy".
* Added an additional "host-only" interface in Parallels and added it to the proxy VM
* Used an existing (different) Ubuntu 18.04 Parallels VM as the ddev/docker environment and added the host only interface to it.  I'll call this machine "workstation".
* Turned off the primary network interface in the workstation, so it had no direct network connectivity, verified that ping of internet addresses failed.
* Configured the workstation VM with system-wide proxy settings using the regular Ubuntu network setting GUI (in this case HTTP/HTTPS proxies using 10.37.129.4).
* Configured the Firefox browser on "workstation" to use the system-configured proxy and verified that it could now operate.
* Verified that curl against internet https locations now worked on the "workstation".
* Configured the docker server as in step 2 above, and verified that `docker pull ubuntu` now worked on "workstation" using the proxy.
* Configured the docker client as in step 3 above and verified that proxy setup was now right in the container by `ddev start`, `ddev ssh`, and using curl inside the container against an HTTPS website.
* Added the .ddev/web-build/Dockerfile from step 4 into the ddev project on the "workstation" and `ddev start`, then `ddev ssh` and `sudo apt-get update` and saw the update happen successfully, all using the proxy.

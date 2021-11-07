# MinIO

This recipe adds a [MinIO](https://min.io/) container to a project.

[MinIO](https://min.io/) is a S3 compatible object-storage.
It can be used, to run an S3 instance locally, in case the hosted S3 is not reachable (like developing while offline)

## Installation

* Copy the `docker-compose.minio.yaml` file to your project's DDEV root folder (`.ddev/docker-compose.minio.yaml`)
* Copy the `minio-build` folder to your project's DDEV root folder (`.ddev/minio-build`)
* Copy the `commands/minio` directory to the commands folder of your project's DDEV commands folder (`.ddev/commands/minio/mc`) and make sure it's executable, `chmod +x .ddev/commands/minio/mc`.
* Start (or restart) DDEV to have the service initialized: `ddev start`

## Connection
* MinIO is available at `ddev-<projectname>-minio:9000` **inside the containers** and at `https://<projectname>.ddev.site:9000` **outside the containers**
* If `https://<projectname>.ddev.site:9000` is opened in the browser, it will redirect to the object browser

## Configuration
The server is configured through the environment variables in `docker-compose.minio.yaml`
Default credentials (for API and  object browser):
* MINIO_ACCESS_KEY=minio
* MINIO_SECRET_KEY=minio123

> By default, all the files managed by MinIO will be stored in a persistent Volume with the name `<projectname>-minio`.
> This volume will not be deleted automatically by DDEV when deleting your project. You will need to delete it manually!

## Additional configuration
The MinIO container does have `mc` ([MinIO Client](https://docs.min.io/docs/minio-client-quickstart-guide)) already present. But it is not configured out of the box.
You will need to configure it manually and create your bucket!
This can be done by performing the following commands:

```bash
ddev mc alias set local http://localhost:9000 minio minio123  # Configure the local alias in mc 
ddev mc mb minio/default -p # Create a bucket named "default"
mc policy set download minio/default # Set the bucket policy to download
```
> If you have changed the default access key and/or secret, you will need to use these values in the commands

Alternatively, you could do this automatically with a post-start [hook](https://ddev.readthedocs.io/en/stable/users/extending-commands/)
Example:
```yaml
hooks:
  post-start:
    - exec: "mc alias set local http://localhost:9000 minio minio123"
      service: minio
    - exec: "mc mb minio/default -p"
      service: minio
    - exec: "mc policy set download minio/default"
      service: minio
```
> You can find these hooks in example.hooks.yaml

## Alternative clients
MinIO's API is fully compatible to Amazon S3 and besides mc ([MinIO Client](https://docs.min.io/docs/minio-client-quickstart-guide)) it can be used with other supported clients like [aws-cli](https://docs.min.io/docs/aws-cli-with-minio), [s3cmd](https://docs.min.io/docs/s3cmd-with-minio) 

## Additional links
[MinIO Documentation](https://docs.min.io/)
[MinIO Docker image](https://hub.docker.com/r/minio/minio)
[MinIO Client Docker image](https://hub.docker.com/r/minio/mc)
[ddev Hooks](https://ddev.readthedocs.io/en/stable/users/extending-commands/)

**Contributed by [@NBZ4live](https://github.com/NBZ4live)**

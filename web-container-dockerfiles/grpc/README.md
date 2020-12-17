# PHP gRPC

Adds protobuf and grpc PHP modules to web-container.
This allows to create clients to interact with external gRPC services.

The installation can take some minutes, because the modules are compiled during the Docker image creation.

## Verify installation

The following command should print the two compiled modules.

```bash
ddev exec php -m | grep -i 'grpc\|protobuf'
```

## Example Project

An example project can be found here: <https://github.com/cmuench/grpc-demo/tree/master/examples/php>

**Contributed by [@cmuench](https://github.com/cmuench)**

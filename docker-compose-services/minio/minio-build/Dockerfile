FROM minio/minio:latest

COPY --from=minio/mc:latest /usr/bin/mc /usr/bin/mc

ENTRYPOINT ["/usr/bin/docker-entrypoint.sh"]

VOLUME ["/data"]

CMD ["minio"]

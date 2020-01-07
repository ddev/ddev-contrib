# Pull Production DB Custom Command (ddev fetchproductiondb)

1. Copy the [fetchproductiondb](./fetchproductiondb) command to the .ddev/commands/host/ directory.
2. adjust $SSH_TARGET and $TARGET_DBNAME in the command
3. If $SSH_TARGET user on host does not already have permissions on the database, you can put credentials in ~/.my.cnf on the server as shown here:

```ini
[client]
user=username
password=password
```

now you can run `ddev fetchproductiondb`. You can easily build the same for files using rsync.

**Contributed by [@kaystrobach](https://github.com/kaystrobach)**

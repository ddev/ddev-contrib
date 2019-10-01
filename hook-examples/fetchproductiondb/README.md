# Usage of the pull production db hook

1. adjust username / host and db name
1. login into your server and adjust the config `~/.mysql/project.cnf` file to automatically login

```ini
[client]
user=username
password=password
```

now you can call `ddev fetchproductiondb` you can easily build the same for files using rsync

# Configuring phpmyadmin through a user settings file

This simple [docker-compose.phpmyadmin.yaml](docker-compose.phpmyadmin.yaml) just mounts a file from the host into the dba container.

You can create a directory in the `.ddev` folder named `phpmyadmin`. In there you can create a custom settings file `config.user.inc.php`.

When you restart ddev, the settings file will be used when starting phpmyadmin.

Example file contents of `config.user.inc.php`:

```php
<?php

$cfg['Lang'] = 'nl';
$cfg['DefaultLang'] = 'nl';
```

An overview of all the possible settings can be found in [the phpmyadmin manual](https://docs.phpmyadmin.net/en/latest/config.html#config).
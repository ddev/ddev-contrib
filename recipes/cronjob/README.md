# enable cronjob on start or on demand

1. Install the `ddev cron` custom command [commands/web/cron](commands/web/cron) in your .ddev/commands/web directory. Make sure that it's executable (`chmod +x .ddev/commands/web/cron`).
1. Place [config.cron.yml](config.cron.yml) in the .ddev directory (or add it to your .ddev/config.yaml); it will run the custom `ddev cron` command on project start, which will run a cronjob for typo3 scheduler:run on every minute. 

To run cron on demand, run `ddev cron`.

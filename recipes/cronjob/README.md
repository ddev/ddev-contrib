# Running TYPO3 Cron inside the web container

This recipe provides two completely different techniques to do TYPO3 cron inside the web container.

* Enable Linux cron on `ddev start` and have it run the TYPO3 cron every minute or
* Just run a custom command (`ddev cron`) which will `ddev exec` the TYPO3 cron process every 60 seconds. (Run it in a separate window.)

## Enable cronjob on start or on demand

1. Install the `ddev cron` custom command [commands/web/cron](commands/web/cron) in your .ddev/commands/web directory. Make sure that it's executable (`chmod +x .ddev/commands/web/cron`). This allows you to simulate a real cron job by just running `ddev cron` in a separate window and it
2. Place [config.cron.yml](config.cron.yml) in the .ddev directory (or add it to your .ddev/config.yaml); it will run the custom `ddev cron` command on project start, which will run a cronjob for typo3 scheduler:run  every minute.
3. Change config.cron.yml to use your username instead of "root" in the first hook. (You can verify your in-container username with `ddev exec id -un`). (So for user rfay, `- exec: echo '*/1 * * * * root TYPO3_CONTEXT=Development/Local /usr/bin/php /var/www/html/public/typo3/sysext/core/bin/typo3 scheduler:run' | sudo tee -a /etc/cron.d/typo3` would become `- exec: echo '*/1 * * * * rfay TYPO3_CONTEXT=Development/Local /usr/bin/php /var/www/html/public/typo3/sysext/core/bin/typo3 scheduler:run' | sudo tee -a /etc/cron.d/typo3`)

## Run TYPO3 cron via `ddev exec` from a separate window

To run the TYPO3 cron process every 60 seconds, use the `ddev cron` custom command provided here.

1. Install [commands/web/cron](commands/web/cron) into your project's .ddev/commands/web directory.
2. Make it executable (`chmod +x .ddev/commands/web/cron`)
3. After starting the project, run `ddev cron` in a separate window and let it do its job.

**Contributed by [@thomaskieslich](https://github.com/thomaskieslich)**

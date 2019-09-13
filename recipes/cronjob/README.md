# enable cronjob on start or on demand

Use config.cron.yml to run cronjob always at start. 
It runs a cronjob for typo3 scheduler:run on every Minute. 

If you like to run the cronjob on demand, you can run the custom command:
```
ddev cron
```

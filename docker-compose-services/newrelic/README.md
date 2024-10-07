# New Relic

This recipe adds a New Relic daemon service and PHP agent to the `web` container.

Once configured it will begin reporting data to New Relic. Your DDEV project name will be the app name reported in your New Relic APM list.

## Configuration

There are two configuration items in `docker-compose.newrelic.yaml`.

* `NEW_RELIC_LICENSE_KEY`: You must specify your license key.
* `NEW_RELIC_AGENT_VERSION`: Specify the New Relic agent version.

# PHPCS on pre-commit _without_ PHP on host

Runs PHPCS from **inside** DDEV, regardless if you are committing from your host
machine.

**Does not require PHP to be installed on the host machine!**

## Dependencies

This requires [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer) to be
installed and configured with a `phpcs.xml` file. A sample configuration for
Drupal can be found below in this file.

## Installation

Copy `pre-commit` and `pre-commit-phpcs.php` under `PROJECT_ROOT/scripts/git/`
and then:
```
cd $(git rev-parse --show-cdup) # Go to project root, where .git folder is
chmod +x scripts/git/pre-commit
cd .git/hooks && ln -s ../../scripts/git/pre-commit
```

### Drupal Installation
Requires [Drupal standards](https://www.drupal.org/project/coder) installed in your project.
The recommended way to do this is by:
```
ddev composer require --dev drupal/coder dealerdirect/phpcodesniffer-composer-installer
```

After composer completes you should have phpcs installed. You can verify it
with `ddev exec vendor/bin/phpcs -i`. You should see `Drupal, DrupalPractice` in the
installed coding standards.

#### Sample `phpcs.xml` for Drupal development

```xml
<?xml version="1.0" encoding="UTF-8"?>
<ruleset name="drupal_website_development">
  <description>PHP CodeSniffer configuration for Drupal website development.</description>

  <arg name="extensions" value="yaml,yml,php,inc,module,install,info,test,profile,theme,css,js"/>
  <arg name="report" value="full"/>
  <arg value="p"/>
  <arg name="colors"/>

  <!--Include custom code.-->
  <file>RoboFile.php</file>
  <file>web/modules/custom</file>
  <file>web/themes/custom</file>

  <!--Exclude third party code.-->
  <exclude-pattern>./.ddev</exclude-pattern>
  <exclude-pattern>./vendor</exclude-pattern>
  <exclude-pattern>./web/core</exclude-pattern>
  <exclude-pattern>./web/libraries</exclude-pattern>
  <exclude-pattern>./web/modules/contrib</exclude-pattern>
  <exclude-pattern>./web/themes/contrib</exclude-pattern>
  <exclude-pattern>./web/sites</exclude-pattern>

  <!--Exclude Drupal generated config files.-->
  <exclude-pattern>./config</exclude-pattern>

  <rule ref="Drupal" />
  <rule ref="DrupalPractice" />

</ruleset>
```

#### Resources

- https://www.drupal.org/node/1419988
- https://www.drupal.org/docs/contributed-modules/code-review-module/php-codesniffer-command-line-usage


## Usage

- Once installed the hook will run on `pre-commit`, checking files to be commited.
- Add ignored files/files in your `phpcs.xml` file.

---

**Contributed by [@bserem](https://github.com/bserem)**

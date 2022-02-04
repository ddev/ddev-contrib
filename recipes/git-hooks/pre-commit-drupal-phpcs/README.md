# Drupal PHPCS on pre-commit without PHP on host

Runs PHPCS from **inside** DDEV, regardless if you are committing from your host
machine.

**Does not require PHP to be installed on the host machine!**

## Dependencies

This requires [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer) and the
[Drupal standards](https://www.drupal.org/project/coder) installed in your project.
The recommended way to do this is by:
```
ddev composer require --dev drupal/coder dealerdirect/phpcodesniffer-composer-installer
```

After composer completes you should have phpcs installed. You can verify it
with `ddev exec vendor/bin/phpcs -i`. You should see `Drupal, DrupalPractice` in the
installed coding standards.

### Resources

- https://www.drupal.org/node/1419988
- https://www.drupal.org/docs/contributed-modules/code-review-module/php-codesniffer-command-line-usage

## Installation

Copy `pre-commit` and `pre-commit-phpcs.php` under `PROJECT_ROOT/scripts/git/`
and then:
```
cd $(git rev-parse --show-cdup) # Go to project root, where .git folder is
chmod +x scripts/git/pre-commit
cd .git/hooks && ln -s ../../scripts/git/pre-commit
```

### Advanced installation

Paste the files wherever you want, but change the paths on lines 5 and 7
in `pre-commit` file. **Don't forget to make the hook executable!**

## Modifying for non-Drupal use

This hook is having Drupal in mind but it can be easily changed to any system.
Please see the discussion from https://github.com/drud/ddev-contrib/pull/197#issuecomment-1029523141
onwards.

---

**Contributed by [@bserem](https://github.com/bserem)**

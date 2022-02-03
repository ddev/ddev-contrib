# Drupal PHPCS on pre-commit without PHP on host

Runs PHPCS from **inside** DDEV, regardless if you are committing from your host
machine.

**Does not require PHP to be installed on the host machine!**

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

**Contributed by [@bserem](https://github.com/bserem)**

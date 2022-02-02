# Drupal pre-commit PHPCS

Runs PHPCS on the files to be commited from **inside** DDEV, regardless if
you are committing from your host machine or from inside the container.

## Installation

Copy `pre-commit` and `pre-commit.php` under `PROJECT_ROOT/scripts/git/`
and then:
```
chmod +x scripts/git/pre-commit
cd .git/hooks && ln -s ../../scripts/git/pre-commit
```

### Advanced installation

Paste the files wherever you want, but change the paths on lines 5 and 7
in `pre-commit` file.
Don't forget to make the hook executable!

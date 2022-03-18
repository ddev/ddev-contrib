# Run Laravel `tinker` or Drupal's `drush php` with a single command <!-- omit in toc -->

- [Installation](#installation)
  - [Per-project](#per-project)
- [Usage](#usage)
  - [Arguments](#arguments)

Both Laravel and Drupal have an interactive debugger & REPL environment for tinkering in PHP. You can test various php statements, resolve services or even query the database! Both environment's are customized versions of the excellent [PsySh](https://psysh.org/).

- Laravel: [`php artisan tinker`](https://laravel.com/docs/artisan#tinker)

- Drupal via a Drush: [`drush php`](https://www.drush.org/latest/commands/php_cli/)

This new command, `ddev tinker`, checks which project you are currently in, and runs the correct command for the project. If you bounce between projects types, this command is really useful.

## Installation

This command works best if installed globally (set-and-forget). It can then be accessed in any Laravel or Drupal project.

- Copy the [web/tinker](web/tinker) file into `~/.ddev/commands/web`.

### Per-project

You could also use this command on a per-project basis.

- Copy the [web/tinker](web/tinker) file into your project `./.ddev/commands/web`.

## Usage

To start your framework's REPL environment, simply type the follow:

```shell
ddev tinker
```

### Arguments

- Tinker can accept simple arguments.

```shell
$ ddev tinker 6+8
14
```

- More complex arguments should be wrapped with <kbd>'</kbd>.

```shell
$ ddev tinker 'User::first()'
[!] Aliasing 'User' to 'App\Models\User' for this Tinker session.
App\Models\User^ {#4400
...

$ ddev tinker 'node_access_rebuild()'
 [notice] Message: Content permissions have been rebuilt.

$ ddev tinker '$node = \Drupal\node\Entity\Node::load(1); print $node->getTitle();'
Who Doesn’t Like a Good Waterfall?
```

While this might be helpful for a quick one-off command, it's recommend to run `ddev tinker` for tinkering to avoid any Docker connection delays between multiple commands.

- Wrapping may also work with <kbd>"</kbd>, depending on the command used. For more consistent results between frameworks and host OS, it is recommended to use <kbd>'</kbd>.
- See https://github.com/drud/ddev/issues/2547

**Contributed by [@tyler36](https://github.com/tyler36)**

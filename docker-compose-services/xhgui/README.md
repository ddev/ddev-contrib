# XHGui

This container provides a XHGui container for your project so you can collect performance information
provided by `xhprof`. 

## Warning

This recipe has a dev environment on mind.
Profiling production environments with this recipe is probably not a good idea.

## Installation

### Your DDEV config
You need the `xhprof` php module. The easiest way is adding
```
webimage_extra_packages: [php7.4-xhprof]
```
to your `.ddev/config.yaml` file.

### Your application

Your application needs to have a profiler set up.

If your application uses composer, you can install it with

```
ddev composer require perftools/php-profiler
```


You need to place some code for initializing the profiling as soon as possible in the
bootstrap of your application.

In the `examples` folder you will find the collector initialization 
and the config for that collector.

#### Drupal 8+ based projects

An easy way of doing this in Drupal, is copying those two files in the `examples` folder to your
`sites/default` folder, and append to your `settings.ddev.php`.
```
require_once __DIR__ . '/xhgui.collector.php';
```

If you want to stop profiling, you can just comment/remove that line.
Take into account that with the default configuration, every time you 
`ddev start`, DDEV will recreate this file.

#### WordPress projects

TBD.

### Service initialization

Start (or restart) DDEV to have the service initialized when you are ready: `ddev start`
Remember, `settings.ddev.php` might be rewritten and you need to do changes there.

**Contributed by [@penyaskito](https://github.com/penyaskito)**

**Help and feedback from**  [@randyfay](https://github.com/randyfay), [@e0ipso](https://github.com/e0ipso), [@andypost](https://github.com/andypost) 

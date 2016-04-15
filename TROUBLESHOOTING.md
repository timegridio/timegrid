# Installation Troubleshooting

## Uncaught exception 'ReflectionException' when running artisan

### Problem

When trying to install, I get this error every time I want to run any `php artisan` command.

```
Fatal error: Uncaught exception 'ReflectionException' with message 'Class log does not exist
```

### Background

It seems that `dev` packages are not installed and Laravel complains when it tries to load them, so the solution is to
install them with composer if you are on a development environment.

### Solution

Run `composer install --dev` instead of `composer install`

### Reference

[See Issue Report](https://github.com/alariva/timegrid/issues/52)

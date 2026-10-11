# Statamic Maintenance

![last tag](https://img.shields.io/github/v/tag/samosadlaker/statamic-maintenance?style=flat-square)

Maintenance addon for Statamic inspired by [plugrbase/statamic-maintenance-mode](https://github.com/plugrbase/statamic-maintenance-mode)

This addon allows you to put your site into maintenance mode. When maintenance mode is enabled, your site will display a maintenance page to all visitors except Control Panel users (super users or users with the access cp permission).

You can customize the maintenance page or use the default one.

## Features
- Simple and quick setup
- Fully customizable to suit your needs
- Integrated Bard field for rich text formatting
- Supports dark mode for a sleek appearance

## Compatibility

- Statamic 6.x

## Installation

You can install this addon via Composer:

``` bash
composer require samosadlaker/statamic-maintenance
```

## Control Panel

The settings page is rendered with Statamic 6's built-in publish form, so the addon
ships no Control Panel assets and requires no `npm` build step.

Use the **Use default maintenance page** toggle to switch between the addon's built-in
page and a custom template. When it is disabled, a **Custom Maintenance Page** field
appears and lets you pick one of your application's templates.

## Configuration

The addon stores its settings in `content/maintenance.yaml` and registers:

- CP settings page: `cp/maintenance`
- Frontend maintenance page: `/maintenance`

Bypass behavior during maintenance mode:

- Super users
- Users with the `access cp` permission

## Production Notes

- Keep `content/maintenance.yaml` writable by your deployment/runtime user.
- If you customize the maintenance view, publish the views:

```bash
php artisan vendor:publish --tag=statamic-maintenance-views
```

- Clear and refresh Statamic content caches after deployment when needed:

```bash
php artisan statamic:stache:clear
php artisan statamic:stache:warm
```

## Local Testing

Run tests locally:

```bash
vendor/bin/phpunit -c phpunit.xml
```

## Showcase

![control panel](https://i.imgur.com/VE2pZM4.png)

In the control panel, you can set a custom Title, Message, and Maintenance Page. Toggle **Use default maintenance page** to use the addon's built-in page, or pick a custom template.


## License 
The MIT License (MIT). Please see [License File](LICENSE) for more information.
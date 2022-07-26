# Blog

This package implements the blog, article and kiosk.

## Installation

1. Add BlogServiceProvider to `config/app.php` under `providers`:

```php
'providers' => [
    ...

    \ARKEcosystem\Foundation\Providers\BlogServiceProvider::class,

    ...
],
```

2. Publish the `config/blog.php` file:

```bash
php artisan vendor:publish --provider="ARKEcosystem\Foundation\Providers\BlogServiceProvider" --tag="config"
```

**Protip**: instead of running step 2 manually, you can add the following to your `post-autoload-dump` property in `composer.json`:

```json
"post-autoload-dump": [
    "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
    "@php artisan package:discover --ansi",
    "@php artisan vendor:publish --provider=\"ARKEcosystem\\Foundation\\Providers\\BlogServiceProvider\" --tag=\"config\" --tag=\"blog-migrations\""
],
```

# Laravel Telecope

> An elegant debug assistant for the Laravel framework.

## Installation

1. Add `laravel/telescope` to `composer.json` to prevent auto-discovery

```json
"extra": {
    "laravel": {
        "dont-discover": [
            "laravel/telescope"
        ]
    }
},
```

2. Add `TelescopeServiceProvider` to the app config

```php
'providers' => [
    ...

    ARKEcosystem\Foundation\Providers\TelescopeServiceProvider::class,

    ...
],
```

3. Configure `.env` for local

```
APP_ENV=local
APP_DEBUG=true
```

4. Configure `.env` for production

```
APP_ENV=production
APP_DEBUG=false
```
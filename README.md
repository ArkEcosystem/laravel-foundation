# Laravel Foundation

<p align="center">
    <img src="/banner.png" />
</p>

> Scaffolding for Laravel. Powered by TailwindCSS and Livewire.

[List of the available components](https://github.com/ArkEcosystem/laravel-foundation/usage/ui.md#available-components)

## Prerequisites

Since this package relies on a few 3rd party packages, you will need to have the following installed and configured in your project:

- [Alpinejs](https://github.com/alpinejs/alpine)
- [TailwindCSS](https://tailwindcss.com/)
- [TailwindUI](https://tailwindui.com/)
- [Livewire](https://laravel-livewire.com/)

## Installation

Require with composer: `composer require arkecosystem/foundation`

## Usage

- [CommonMark](/usage/commonmark.md)
- [Fortify](/usage/fortify.md)
- [Hermes](/usage/hermes.md)
- [Stan](/usage/stan.md)
- [UI](/usage/ui.md)

## Examples

- [CommonMark](/examples/commonmark.md)
- [Fortify](/examples/fortify.md)
- [Hermes](/examples/hermes.md)
- [UI](/examples/ui.md)

## Composer Scripts

Add those scripts to `composer.json`

```json
"scripts": [
    "analyse": [
        "vendor/bin/phpstan analyse --configuration=vendor/arkecosystem/foundation/phpstan.neon --memory-limit=2G"
    ],
    "format": [
        "vendor/bin/php-cs-fixer fix --config=vendor/arkecosystem/foundation/.php-cs-fixer.php"
    ],
    "refactor": [
        "./vendor/bin/rector process --config=vendor/arkecosystem/foundation/rector.php"
    ],
    "test": [
        "./vendor/bin/pest"
    ],
    "test:fast": [
        "./vendor/bin/pest --parallel"
    ],
    "test:coverage": [
        "./vendor/bin/pest --coverage --min=100 --coverage-html=.coverage --coverage-clover=coverage.xml"
    ]
],
```

## Working on Components Locally

This package contains a lot of frontend components, but no frontend views itself. So when you need to work on it, you rely on the frontend from another  project. Usually this can be done by having composer symlink this package, but in this case there is a second step required to ensure you can run `yarn watch`,  `yarn prod` etc. 

I'll get into it in detail and will use the marketsquare.io project as an example. Let's assume that both the marketsquare.io and laravel-foundation git repo's are installed in the `/Users/my-user/projects/` folder on our local development machine.

### Step 1 - Composer Symlink

In the `composer.json` file from marketsquare.io under "repositories" add the laravel-foundation as a path:
```json
"repositories": [
    {
        "type": "path",
        "url": "../laravel-foundation"
    }
]
```
After that run `composer require arkecosystem/foundation --ignore-platform-reqs -W`. The laravel-foundation package is now symlinked and you can work in your IDE from within your `laravel-foundation` repo.

### Step 2 - Symlink node_modules

If you would run `yarn watch` from within your marketsquare.io repo you'll get a lot of errors because dependencies are not smart enough to know they're in a symlinked directory.

* Delete the `node_modules` directory on `laravel-foundation`.
* Symlink the `node_modules` directory from marketsquare.io to laravel-foundation by running `ln -s /Users/my-user/projects/marketsquare.io/node_modules node_modules` (from within your laravel-foundation repo).

Now, when you go back to your marketsquare.io repo, you can run `yarn watch`.

Don't forget to remove the symlinking after you're done.

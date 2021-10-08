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

```
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

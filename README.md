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
- [Documentation](/usage/documentation.md)
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

This package contains a lot of frontend components, but no frontend views itself. So when you need to work on it, you rely on the frontend from another project. Usually this can be done by having composer symlink this package, but in this case there is a second step required to ensure you can run `yarn watch`, `yarn prod` etc. 

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

### Turn those steps into scripts

> **_Keep in mind_**:
>
> these scripts are written for Mac users. If you use another OS you may need to tweak them accordingly.
>
> `unlink:foundation` uses `git` commands to restore the current project.

To improve your workflow you can turn those steps into scripts and use them directly in your command line, like:
```bash
$ link:foundation
$ unlink:foundation
```

You can copy/paste them in your `.bashrc`, `.aliases` or whatever file you set up to manage your aliases.

Before jumping into the code, let me explain what you can do with them ([skip to code](/#code)).

For these examples we use `marketsquare.io` and `laravel-foundation` repos, assuming that both are installed in the same folder (`/Users/my-user/projects`) on our local development machine.

#### symlink your current project to laravel-foundation
```bash
# move into marketsquare.io folder
$ cd /Users/my-user/projects/marketsquare.io

# symlink to laravel-foundation repo
$ link:foundation
```

That's it!

The script automatically tries to guess where the `laravel-foundation` repo is located and symlinks the current project to it (in this case `marketsquare.io`).

If the current project and `laravel-foundation` repos are not in the same folder, the script tries to move one level back (`../../`) and tries again.
If `laravel-foundation` is not found, the script exits and outputs an error message.

You can always specify a custom path, by passing it as an argument
```bash
$ link:foundation 'Users/john/repos/laravel-foundation'
```

#### remove symlink from your current project
```bash
# move into marketsquare.io folder
$ cd /Users/my-user/projects/marketsquare.io

# remove symlink
$ unlink:foundation
```

Again, that's it!

The script looks for `.symlink_foundation` temp file (created by `link:foundation`), that contains the symlinked path.
If not found, it tries to guess where the `laravel-foundation` repo is located and removes the symlink from the current project (in this case `marketsquare.io`).

If the current project and `laravel-foundation` repos are not in the same folder, the script tries to move one level back (`../../`) and tries again.
If `laravel-foundation` is not found, the script exits and outputs an error message.

You can always specify a custom path, by passing it as an argument
```bash
$ unlink:foundation 'Users/john/repos/laravel-foundation'
```

#### code
Scripts are self-explanatory, plus they have comments on each line 😉.

```bash
function link:foundation() {

    # Check if already symlinked
    [ -f .symlink_foundation ] && { echo "already symlinked"; return; }

    # Get path from args or guess it
    if [ "$1" != "" ]; then
        FOUNDATION="$1"
    elif [ -d ../laravel-foundation ]; then
        FOUNDATION="../laravel-foundation"
    elif [ -d ../../laravel-foundation ]; then
        FOUNDATION="../../laravel-foundation"
    else
        echo "Unable to find `laravel-foundation`"
        return
    fi

    # Generate random string
    RANDOM_STRING=$(base64 /dev/urandom | tr -d '/+' | dd bs=6 count=1 2>/dev/null)

    # Set Composer repo
    composer config repositories.${RANDOM_STRING} '{"type": "path", "url": "'${FOUNDATION}'"}'

    # Require arkecosystem/foundation
    composer require arkecosystem/foundation --ignore-platform-reqs -W

    # Remove node_modules folder
    rm -rf ${FOUNDATION}/node_modules

    # Symlink to arkecosystem/foundation node_modules folder
    ln -s $(pwd)/node_modules ${FOUNDATION}/node_modules

    # Create .symlink_foundation temp file
    echo ${FOUNDATION} >> .symlink_foundation

    # Inform user that all went ok
    echo "${FOUNDATION} has been symlinked"
}

function unlink:foundation() {

    # Get path from .symlink_foundation file or from args or guess it
    if [ -f .symlink_foundation ]; then
        FOUNDATION=$(cat .symlink_foundation)
    elif [ "$1" != "" ]; then
        FOUNDATION="$1"
    elif [ -d ../laravel-foundation ]; then
        FOUNDATION="../laravel-foundation"
    elif [ -d ../../laravel-foundation ]; then
        FOUNDATION="../../laravel-foundation"
    else
        echo "Unable to find `laravel-foundation`"
        return
    fi

    # Remove symlink
    unlink ${FOUNDATION}/node_modules

    # Remove temp file
    rm -rf .symlink_foundation

    # Clean up repo
    git reset --hard
    git clean -df

    # Inform user that all went ok
    echo "${FOUNDATION} symlink has been removed"
}
```

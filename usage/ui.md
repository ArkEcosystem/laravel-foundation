# Laravel UI

> User-Interface Scaffolding for Laravel. Powered by TailwindCSS.

[List of the available components](https://github.com/ArkEcosystem/laravel-foundation/blob/main/usage/ui.md#available-components)

## Prerequisites

Since this package relies on a few 3rd party packages, you will need to have the following installed and configured in your project:

- [Alpinejs](https://github.com/alpinejs/alpine)
- [TailwindCSS](https://tailwindcss.com/)
- [TailwindUI](https://tailwindui.com/)
- [Livewire](https://laravel-livewire.com/)

## Installation

1. Publish all the assets / views with `php artisan vendor:publish --provider="ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider" --tag="css" --tag="fonts" --force`. If you need custom pagination, then also run `php artisan vendor:publish --provider="ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider" --tag="pagination"`
2. Import the vendor css assets in your `app.css` file
3. Import the vendor `tailwind.config.js` file in your own tailwind config and build on top of that if you need additional changes
4. Use the components in your project with `<x-ark-component>`
5. Add the following snippet to your `webpack.mix.js` file to be able to use the `@ui` alias:

```js
mix.webpackConfig({
    resolve: {
        alias: {
            '@ui': path.resolve(__dirname, 'vendor/arkecosystem/foundation/resources/assets/')
        }
    }
})
...
```

6. Make sure to set `render_on_redirect => true` in the Livewire configuration file at `config/livewire.php`. Alternatively, publish the livewire configuration file from this repository.


**Protip**: instead of running step 3 manually, you can add the following to your `post-autoload-dump` property in `composer.json`:

```json
"post-autoload-dump": [
    "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
    "@php artisan package:discover --ansi",
    "@php artisan vendor:publish --provider=\"ARKEcosystem\\UserInterface\\UserInterfaceServiceProvider\" --tag=\"css\" --tag=\"fonts\""
],
```

**Protip**: you can publish individual assets by using their tag, e.g. `--tag="css"`, `--tag="images"`, etc

**Protip 2**: in order to lazy-load icons, you will need to publish them by using their tag, e.g. `--tag=\"icons\"`

### Navbar / Avatar Component

The navigation bar makes use of our own PHP implementation of [picasso](https://github.com/vechain/picasso) to generate a default avatar (in line with the Desktop Wallet). You will need to set this up in your project as follows:

1. Pass an `$identifier` value to the navbar component be used as seed for the generation of the image

### Clipboard

1. Add clipboard to Laravel Mix config

```js
.copy('vendor/arkecosystem/foundation/resources/assets/js/clipboard.js', 'public/js/clipboard.js')
```

2. Add clipboard to any pages that need it

```blade
@push('scripts')
    <script src="{{ mix('js/clipboard.js')}}"></script>
@endpush
```

3. Install `tippy.js`

```bash
yarn add tippy.js
```

4. Add the following snippet to your `resources/app.js`

```js
window.initClipboard = () => {
    tippy('.clipboard', {
        trigger: 'click',
        content: (reference) => reference.getAttribute('tooltip-content'),
        onShow(instance) {
            setTimeout(() => {
                instance.hide();
            }, 3000);
        },
    });
}
```

### Modals

1. Install `body-scroll-lock` and `focus-trap`

```bash
yarn add body-scroll-lock
yarn add focus-trap
```

2. Import the modal script in your `resources/js/app.js` file

```js
import Modal from "@ui/js/modal";

window.Modal = Modal;
```

### Tables

To create a table you can use the following components:

- `<x-ark-tables.table>` => creates the `table` tag inside a container
- `<x-ark-tables.row>` => creates the `tr` tag
- `<x-ark-tables.header>` => creates the `th` tag
- `<x-ark-tables.cell>` => creates the `td` tag

You just need to use the different components as you normally would with a regular table.

```html
<x-ark-tables.table>
    <thead>
        <x-ark-tables.row>
            <x-ark-tables.header>ID</x-ark-tables.header>
            <x-ark-tables.header class="w-full">Name</x-ark-tables.header>
            <x-ark-tables.header class="text-right">Email</x-ark-tables.header>
        </x-ark-tables.row>
    </thead>
    <tbody>
        @foreach($items as $item)
            <x-ark-tables.row :danger="$loop->index === 0">
                <x-ark-tables.cell>{{ $item->id }}</x-ark-tables.cell>
                <x-ark-tables.cell>{{ $item->name }}</x-ark-tables.cell>
                <x-ark-tables.cell>{{ $item->email }}</x-ark-tables.cell>
            </x-ark-tables.row>
        @endforeach
    </tbody>
</x-ark-tables.table>
```

We use components because they contain the CSS classes and HTML needed to build the table according to the style guide and because every component contains a set of useful props:

#### Table `<x-art-tables.table` props


| Props        | Default | Description                                                                                                               |
|--------------|---------|---------------------------------------------------------------------------------------------------------------------------|
| sticky       | `false` | If set it will keep the header on top                                                                                     |
| tableClass   | `null`  | CSS classes to add to the `table` tag                                                                                     |
| noContainer  | `false` | If set it will remove the container that wraps the table                                                                  |
| compact      | `true`  | If set it will add the CSS classes related to the compact version of the table                                            |
| compactUntil | `md`    | If `compact` is set it will apply the compact version until the given breakpoint. Use `false` to use only compact version |


#### Table `<x-art-tables.row` props

| Props   | Default | Description                                                            |
|---------|---------|------------------------------------------------------------------------|
| success | `false` | If set it will add a green background to the row                       |
| info    | `false` | If set it will add a background according to the main color to the row |
| danger  | `false` | If set it will add a red background to the row                         |
| warning | `false` | If set it will add a yeallo background to the row                      |
| tooltip | `false` | If set it will add a tippy tooltip                                     |

#### Table `<x-art-tables.header` props

| Props      | Default | Description                                                                                       |
|------------|---------|---------------------------------------------------------------------------------------------------|
| responsive | `false` | If set it will hide the column according on the breakpoint that is added on the `breakpoint` prop |
| breakpoint | `lg`    | In which breakpoint it will hide the column                                                       |
| firstOn    | `null`  | In which screen sizes this column will be the first one (`xl`, `lg`, etc)                         |
| lastOn     | `null`  | In which screen sizes this column will be the last one (`xl`, `lg`, etc)                          |
| class      | `''`    | Column CSS class                                                                                  |
| name       | `''`    | If set it will use the laravel `@lang`  helper to get the value of the column                     |

#### Table `<x-art-tables.cell` props

| Props      | Default | Description                                                                                       |
|------------|---------|---------------------------------------------------------------------------------------------------|
| responsive | `false` | If set it will hide the column according on the breakpoint that is added on the `breakpoint` prop |
| breakpoint | `lg`    | In which breakpoint it will hide the column                                                       |
| firstOn    | `null`  | In which screen sizes this column will be the first one (`xl`, `lg`, etc)                         |
| lastOn     | `null`  | In which screen sizes this column will be the last one (`xl`, `lg`, etc)                          |
| class      | `''`    | Column CSS class                                                                                  |
| colspan    | `null`  | `td` colspan attribute                                                                            |

### WYSIWYG Markdown editor

> Important: you will need to have `php-tidy` installed for the Markdown parsing. Ensure this is installed on any servers before implementing the markdown editor

1. Install the npm dependencies

```bash
yarn add @toast-ui/editor@^2.5.2 codemirror@^5.62.0
```

2. Ensure to import the markdown script inside the `<head>` tag of your template.

```html
@push('scripts')
    <x-ark-pages-includes-markdown-scripts />
@endpush
```

Assigning to the `window` object is now done in the markdown script itself, therefore there is no need to import and assign this script manually!

3. Configure webpack.mix with the markdown plugin

```js
// Import the following script in the `webpack.mix.js` file
require('./vendor/arkecosystem/foundation/laravel-mix/markdownPlugin.js');

// If the Tailwind Config file in your project is `tailwind.config.js`
// you dont need to pass any argument
mix.markdown('tailwind.app.config.js')
```

4. Add the markdown component to your form

```html
<x-ark-markdown name="about" />
```

5. You can change the height and the toolbar preset:

```html
<x-ark-markdown name="about"
    height="300px"
    toolbar="full"
/>
```

6. You can choose to limit the characters to be inserted:

```html
<x-ark-markdown name="about"
    chars-limit="1000"
/>
```

Accepts `full` for all the plugins and `basic` for only text related buttons.

7. If you use the image upload plugin your page will need to have the csrf_token in the metadata.

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### Tags input

1. Add taggle dependency `yarn add taggle` and ensure to copy the scripts to the public directory:

```js
// webpack.mix.js file
    mix.copy('node_modules/taggle/dist/taggle.min.js', 'public/js/taggle.js')
```

2. Add the Tags script to the main js file

```js
import Tags from "@ui/js/tags";

window.Tags = Tags;
```

3. Ensure to import the taggle scripts

```html
@push('scripts')
    <script src="{{ mix('js/taggle.js')}}"></script>
@endpush
```

4. Use the component like the rest of the components. It accepts `tags` and `allowed-tags` props.

```html
<x-ark-tags :tags="['tag1', 'tag2']" name="tags" :allowed-tags="['taga', 'tagb']" />
```

### User tagger input

1. Add tributejs dependency `yarn add tributejs`  and ensure to copy the scripts to the public directory:

```js
// webpack.mix.js file
    mix.copy('node_modules/tributejs/dist/tribute.min.js', 'public/js/tribute.js')
```

2. Import the user tagger script into the main js file and import the styles in your css file

```js
import "@ui/js/user-tagger.js";
```

```css
@import "../../vendor/arkecosystem/foundation/resources/assets/css/_user_tagger.css";
```

3. Ensure to import the tributejs scripts in the places where the component will be used

```html
@push('scripts')
    <script src="{{ mix('js/tribute.js')}}"></script>
@endpush
```

4. Use the component like you use the textarea input

```html
<x-ark-user-tagger
    name="body"
    :placeholder="trans('forms.review.create_message_length')"
    rows="5"
    wire:model="body"
    maxlength="1000"
    required
    hide-label
>{{ $body }}</x-ark-user-tagger>
```

5. This component makes a GET request to the `/api/users/autocomplete` endpoint with the query as `q`, that query should be used to search the users and should return them in the following format:

Note: You can change the the URL by using the `endpoint` prop.

```json
[
    {
        "name":"Foo Bar",
        "username":"foo.bar",
        "avatar":"SVG AVATAR OR URL"
    },
    {
        "name":"Other user",
        "username":"user_name",
        "avatar":"SVG AVATAR OR URL"
    },
    ...
]
```

6. The component accepts a `usersInContext` prop that expects an array of usernames. These usernames will be sent in the search query request as  `context` and can be used to show those users first in the response. Useful to show the user in the conversation first.

#### Livewire modals

To use the Livewire modals, use the `ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasModal` trait in your component class. The trait adds the `closeModal` and `openModal` methods that toggle the `modalShown` property that is the one you should use to whether show or hide the modal.

**Important**: If you need to use a different variable to close the modal, or you can't make use of the trait for a reason, make sure to emit the `modalClosed` event as that is required for proper handling of the modals on the frontend! If you fail to emit this event, the browser window will not be scrollable after the modal disappears.

You can disable the focus trap by passing a parameter in the second argument:
```php
<div x-data="Modal.livewire({{ $extraData }}, [\"disableFocusTrap\" => true])">
    <!--...-->
</div>
```

#### Alpine modals

**Important**: for the modals to work properly, they expect a `nav` element inside a `header` element to be used for the header component. If you use the navbar from the UI lib (see `navbar.blade.php`) these elements are already used, but for custom navbars you may need to make adjustments.

There's a few ways you can make use of the new modals in conjunction with Alpine:

For JS-only modals, you need to use the `<x-ark-js-modal />` component. You need to initiate the modal with a name (using the `name` attribute) and it can be opened by calling `Livewire.emit('openModal', 'name-of-my-modal')`

```html
<x-ark-js-modal name="name-of-my-modal'">
    @slot('description')
        My Description
    @endslot
</x-ark-js-modal>

<button onclick="Livewire.emit('openModal', 'name-of-my-modal')">Open modal</button>
```

Alternatively, if you wrap the modal inside another Alpine component, you can use the `Modal.alpine()` method to init the modal (don't forget to call the `init` method on `x-init`).

The `Modal.alpine()` method accepts an object as the first argument. This object will be merged with the original Modal data.

Inside that component, you can use the `show()` method to show the modal:

```html
<div
    x-data="Modal.alpine({}, 'optionalNameOfTheModal')"
    x-init="init"
>
    <button type="button" @click="show">Show modal</button>

    <x-ark-js-modal
        class="w-full max-w-2xl text-left"
        title-class="header-2"
        :init="false"
    >
        @slot('description')
            My Description
        @endslot
    </x-ark-modal>
</div>
```

Note that it is also possible to hook into the lifecycle methods of the modal. You can override the `onBeforeHide`, `onBeforeShow`, `onHidden`, and `onShown` properties with custom methods if you require so.

```html
<div
    x-data="Modal.alpine({
        onHidden: () => {
            alert('The modal was hidden')
        },
        onBeforeShow: () => {
            alert('The modal is about to be shown')
        }
    }"
    x-init="init"
>
    <button type="button" @click="show">Show modal</button>

    <x-ark-js-modal
        class="w-full max-w-2xl text-left"
        title-class="header-2"
        :init="false"
    >
        @slot('description')
            My Description
        @endslot
    </x-ark-js-modal>
</div>
```


```js
import Modal from "@ui/js/modal";

window.Modal = Modal;
```

You can disable the focus trap by passing a parameter in the third argument:
```js
import Modal from "@ui/js/modal";

window.Modal = Modal;

Modal.alpine(
    {}, // extra data
    '', // modal name
    { disableFocusTrap: true } // <-- disable focus trap
)
```

### Tooltips

1. Install `tippy.js`

```bash
yarn add tippy.js
```

2. Add to webpack mix

```js
.js('vendor/arkecosystem/foundation/resources/assets/js/tippy.js', 'public/js')
```

3. Add tippy to any pages that need it

```blade
@push('scripts')
    <script src="{{ mix('js/tippy.js')}}" defer></script>
@endpush
```

### Slider

1. Install `swiper`

```bash
yarn add -D swiper
```

2. Add swiper to Laravel Mix config

```js
.copy('node_modules/swiper/swiper-bundle.min.js', 'public/js/swiper.js')
```

3. Add swiper to any pages that need it

```blade
@push('scripts')
    <script src="{{ mix('js/swiper.js')}}"></script>
@endpush
```

4. Include swiper CSS

```css
@import "../../node_modules/swiper/swiper-bundle.min.css";
```

5. Add the following to the `app.js` file:

```js
import Slider from "@ui/js/slider";

window.Slider = Slider
```

### Date Picker

1. Install `pikaday`

```bash
yarn add -D pikaday
```

2. Include pikaday CSS


```css
@import "../../node_modules/pikaday/css/pikaday.css";
@import '../../vendor/arkecosystem/foundation/resources/assets/css/_pikaday.css';
```

### Notifications Indicator

1. Add this to your user migration table

```php
$table->timestamp('seen_notifications_at')->nullable();
```

2. Register the component in your LivewireServiceProvider file

```php
use Domain\Components\NotificationsIndicator;
...
Livewire::component('notifications-indicator', NotificationsIndicator::class);
```

### Prism Codeblock

1. Add prism js to Laravel webpack mix

```js
.js('vendor/arkecosystem/foundation/resources/assets/js/prism.js', 'public/js')
```

2. Add prism to any pages that need it

```blade
@push('scripts')
    <script src="{{ mix('js/prism.js')}}"></script>
@endpush
```

3. Include prism CSS

```css
@import "../vendor/ark/_prism-theme.css";
```

4. Install `prism.js`

```bash
yarn add -D prism-themes prismjs
```

5. Add the following snippet to `resources/prism.js`

```js
import "../vendor/ark/prism";

document.addEventListener("DOMContentLoaded", () => {
    document
        .querySelectorAll("pre")
        .forEach((pre) => useHighlight(pre, { omitLineNumbers: false }));
});
```

### Image Collection Sortable
1. Install `Livewire Sortable`

```bash
yarn add -D livewire-sortable
```

2. Add the following snippet to your `resources/app.js`

```bash
import 'livewire-sortable'
// Or.
require('livewire-sortable')
```

3. Add `imagesReordered` method to handle index reordering when an image is sorted.

```php
public function imagesReordered(array $ids): void
{
    Media::setNewOrder($ids);
}
```

4. Then, you can use `upload-image-collection` component with sortable functionality.

```blade
<x-ark-upload-image-collection id="media" :images="$this->imageCollection" sortable />
```

### Tabs

Add the following to the `app.js` file:

```js
import "@ui/js/tabs.js";
```

```html
<x-ark-tabbed>
    <x-slot name="tabs">
        <x-ark-tab name="tab-1" />
        <x-ark-tab name="tab-2" />
        <x-ark-tab name="tab-3" />
    </x-slot>

    <x-ark-tab-panel name="tab-1">...</x-ark-tab-panel>
    <x-ark-tab-panel name="tab-2">...</x-ark-tab-panel>
    <x-ark-tab-panel name="tab-3">...</x-ark-tab-panel>
</x-ark-tabbed>
```

For the available parameters, please refer to the [EXAMPLE.md](EXAMPLE.md#tabs)

### Error Pages

There are also default error pages you can use for your Laravel project

1. Run `php artisan vendor:publish --provider="ARKEcosystem\UserInterface\UserInterfaceServiceProvider" --tag="error-pages"`

2. Add the following snippet to your `menus.php` lang file:

```php
'error' => [
    '401' => '401 Unauthorized',
    '404' => '403 Forbidden',
    '404' => '404 Not Found',
    '419' => '419 Unauthorized',
    '429' => '429 Too Many Requests',
    '500' => '500 Internal Server Error',
    '503' => '503 Unavailable',
]
```

3. Please test if the pages work by manually going to a url that should throw an error

## Available Components

- `<x-ark-accordion>`
- `<x-ark-accordion-group>`
- `<x-ark-alert>`
- `<x-ark-breadcrumbs>`
- `<x-ark-checkbox>`
- `<x-ark-clipboard>`
- `<x-ark-dropdown>`
- [`<x-ark-expandable>`](EXAMPLES.md#expandable)
- [`<x-ark-input>`](EXAMPLES.md#input)
- `<x-ark-navbar>`
- `<x-ark-radio>`
- `<x-ark-secondary-menu>`
- `<x-ark-select>`
- `<x-ark-sidebar-link>`
- `<x-ark-tags>`
- `<x-ark-textarea>`
- `<x-ark-toggle>`
- [`<x-ark-upload-image-single>`](EXAMPLES.md#upload-single-image)
- [`<x-ark-upload-image-collection>`](EXAMPLES.md#upload-multiple-images)
- [`<x-ark-font-loader>`](EXAMPLES.md#font-loader)
- [`<x-ark-tabs>`](EXAMPLES.md#tabs)

> See the [example file](EXAMPLES.md) for more in-depth usage examples

### Livewire Pagination Scroll

1. Add the following to `app.js` file:

```js
import "@ui/js/page-scroll";
```

2. Use the `HasPagination` trait on Livewire Components:

```php
use ARKEcosystem\UserInterface\Http\Livewire\Concerns\HasPagination;

class Articles {
    use HasPagination;
}
```

3. Add event trigger at the bottom of the component template:

```html
<div>
    ...

    <x-ark-pagination :results="$articles" class="mt-8" />

    <script>
        window.addEventListener('livewire:load', () => window.livewire.on('pageChanged', () => scrollToQuery('#article-list')));
    </script>
</div>
```

### Pagination

1. Publish the pagination assets

`php artisan vendor:publish --provider="ARKEcosystem\UserInterface\UserInterfaceServiceProvider" --tag="pagination"`

2. Add the following to the `app.js` file:

```js
import Pagination from "@ui/js/pagination";

window.Pagination = Pagination
```

3. All set, now you can use the pagination component

```html
<x-ark-pagination :results="$results"  />
```

### Footer

Add the following snippet to your `urls.php` lang file:

```php
'discord'  => 'https://discord.ark.io/',
'facebook' => 'https://facebook.ark.io/',
'github'   => 'https://github.com/ArkEcosystem',
'linkedin' => 'https://www.linkedin.com/company/ark-ecosystem',
'reddit'   => 'https://reddit.ark.io/',
'twitter'  => 'https://twitter.ark.io/',
'youtube'  => 'https://youtube.ark.io/',
```

## Available Styles

> It's advised to make use of the styles for generic components so we keep them similar throughout projects

- Buttons
- Tables
- Tabs

### In-progress

- more styles, and proper configuration to define where styles are published

## Blade Support

### Avatar

In `config/app.php` under `aliases`, add the following entry:

```
'Avatar' => ARKEcosystem\UserInterface\Support\Avatar::class,
```

### Date Format

In `config/app.php` under `aliases`, add the following entry:

```
'DateFormat' => ARKEcosystem\UserInterface\Support\DateFormat::class,
```

### Format Read Time method for blade (generally used for blog date/time output)

In `config/app.php` under `providers`, add the following entry:

```
ARKEcosystem\UserInterface\Providers\FormatReadTimeServiceProvider::class,
```

### SVG Lazy-Loading Icons

In `config/app.php` under `providers`, add the following entry:

```
ARKEcosystem\UserInterface\Providers\SvgLazyServiceProvider::class,
```

This will initiate the `svgLazy` directive and allow you to load icons from the `arkecosystem/foundation` package. For example:

```
@svgLazy('checkmark', 'w-5 h-5')
```

This will insert the following HTML:

```
<svg lazy="/icons/checkmark.svg" class="w-5 h-5" />
```

**Protip**: You will need lazy.js in order for this to work

### Social share link (generally used for article)

This class generates social share link from a resource url and title.

The available social networks are:
- facebook
- twitter
- reddit

We can also publish the configuration file per-project, by run:
```bash
php artisan vendor:publish --provider="ARKEcosystem\\Foundation\\Providers\\UserInterfaceServiceProvider" --tag="share"
```

Here follow, you can find an example on how to use it.
```php
use ARKEcosystem\Foundation\UserInterface\Support;

$link = Share::page('https://my-website.com/blog/article-page', 'Article Title')->reddit();

// $link contains -> 'https://www.reddit.com/submit?title=Article+Title&url=https://my-website.com/blog/article-page'
```

## Development

If components require changes or if you want to create additional components, you can do so as follows:

### Vendor folder

This approach is recommended to test out smaller changes. You can publish the views by running `php artisan vendor:publish --tag=views`, and they will show up in the `views/vendor/ark` folder. From there you can edit them to your liking and your project will make use of these modified files. Make sure to later commit them to this repository when you have made your changes to keep the files throughout projects in sync.

### Components Folder

When you create a `views/components` folder, you can create new blade files inside it and they will automatically become available through `<x-your-component>` to be used in your project. This way you can create new components, test them, and then copy them to the `arkecosystem/foundation` repo when finished.

Afterwards you can add new components to the local package and use it in your project for testing.

### Icons

If you need to add, replace or delete an icon:
- move the new icon in or remove it from `/resources/assets/icons`
- run `yarn run generate-icon-preview`
- open `icons.html` and check if the icon is present

## Tailwind Configuration

There are a few tailwind configuration additions on which the components rely (e.g. colors and additional shadows) and are therefore expected to use the tailwind config in this repository as basis (you can import it and extend it further if needed).

## Dark Color Theme

Dark color theme is more and more used on website today and many operating systems feature this functionality.
Users might indicate their preference through the operating system setting or by interacting with a theme switcher component.

Since we use Tailwind css with `class` strategy to manage dark mode. 
This strategy had a down-side of not be able to manage the operating system preference.
To by-pass this problem, we can use vanilla javascript and controlling both strategies.

### Script

```html
<x-ark-dark-theme-script />
```

The script is enabled by default, you can disable the script by adding `DARK_MODE_ENABLE=false` on your `.env` file.

#### How to integrate
The script should be inserted on each page in the `head` section. In our case, placing the script in the `app.blade.php` can do the trick.

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        ...

        <title>...</title>
        
        <!-- place the script right after <title> to avoid FOUC (https://en.wikipedia.org/wiki/Flash_of_unstyled_content) -->
        <x-ark-dark-theme-script />
        
        ...
    </head>
    ...
</html>
```

#### What it does

Basically, it uses vanilla javascript to listen to events and uses Local Storage to store the user choice. If the value is not found on Local Storage, it takes the preference from the O.S.

#### How to use

Emits one of these events from Livewire or AlpineJs (scroll down for examples).

| events          | params | description                                                                   |
|-----------------|--------|-------------------------------------------------------------------------------|
| setThemeMode    | theme  | It sets the given theme name.                                                 |
| setOSThemeMode  |        | It sets the theme preference from O.S.                                        |
| toggleThemeMode |        | It toggles the theme from light to dark and vice-versa without persisting it. |

You can listen to custom `theme-changed` event when a theme name is changed. It contains the new theme name applied.

**Example for listening `theme-changed` using AlpineJs**

```html
<div 
    x-data="{dark: window.getThemeMode() === 'dark'}"
    @theme-changed.window="dark = !dark"
>
    <span x-show="dark">dark theme</span>
    <span x-show="!dark">light theme</span>
</div>
```

As you can see in the previous example, the script also provide a helper method to easily get the current theme name.
```js
window.getThemeMode();
// "dark" or "light 
```

**Example using Livewire**

```php
use Livewire\Livewire;

class ThemeSwitcher extends Livewire
{
    protected $listeners = ['themeChanged' => '$refresh'];
    
    public function dark(): void
    {
        $this->dispatchBrowserEvent('setThemeMode', ['theme' => 'dark']);
    }
    
    public function light(): void
    {
        $this->dispatchBrowserEvent('setThemeMode', ['theme' => 'light']);
    }
    
    public function os(): void
    {
        $this->dispatchBrowserEvent('setOSThemeMode');
    }
    
    public function toggle(): void
    {
        $this->dispatchBrowserEvent('toggleThemeMode');
    }
}
```

**Example of Theme Preference Setting page using AlpineJs**

```html
<section>
    <h2>Theme preference</h2>
    
    <button type="button" @click="$dispatch('setThemeMode', {'theme': 'dark'})">Dark</button>
    <button type="button" @click="$dispatch('setThemeMode', {'theme': 'light'})">Light</button>
    <button type="button" @click="$dispatch('setOSThemeMode')">System default</button>
</section>
```

**Example of Theme Switcher component using AlpineJs**

```html
<div x-data="{ isDarkTheme: false }">
    <span id="set-dark-mode">Enable/Disable Dark mode</span> 
    <button 
        role="switch" 
        aria-labelledby="set-dark-mode" 
        x-bind:aria-checked="isDarkTheme" 
        @click="$dispatch('setThemeMode', {'theme': isDarkTheme ? 'dark' : 'light'})"
    >
      <span x-show="isDarkTheme">on</span>
      <span x-show="!isDarkTheme">off</span>
    </button>
</div>
```

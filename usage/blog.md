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

3. If necessary, create a migration for articles and user media


```bash
php artisan make:migration update_media_morphable_items_references
```

Migration example:

```php
<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class UpdateMediaMorphableItemsReferences extends Migration
{
    public function up()
    {
        Media::where('model_type', "App\Models\User")->update(['model_type' => (new User())->getMorphClass()]);
        Media::where('model_type', "App\Models\Article")->update(['model_type' => (new Article())->getMorphClass()]);
    }
}
```

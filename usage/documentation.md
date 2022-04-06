# Documentation

This package provides the discovery, parsing and rendering of documentation via CommonMark. The structure of the documentation has to adhere to https://github.com/ArkEcosystem/docs or discovery will fail.

## Controller

```php
<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use ARKEcosystem\Foundation\Documentation\Document;
use ARKEcosystem\Foundation\Documentation\DocumentView;

class ShowDocumentationController extends Controller
{
    public function __invoke(string $documentation, ?string $page = null)
    {
        return view('app.documentation', [
            'index'    => DocumentView::getIndex('docs', $documentation),
            'content'  => DocumentView::get('docs', $documentation, $page ?? 'intro'),
            'document' => Document::findBySlug($page ? "$documentation/$page" : "$documentation/intro"),
        ]);
    }
}
```

## Route

```php
Route::get('/docs/{documentation}/{page?}', App\Http\Controllers\ShowDocumentationController::class)
    ->name('documentation')
    ->where(['page' => '.*']);
```

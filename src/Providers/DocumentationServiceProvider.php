<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Foundation\Documentation\Documentation;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class DocumentationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(storage_path('app/public/docs'), 'docs');

        Request::macro('onDocs', function ($slug = null, bool $checkGroup = false) {
            if (empty($slug)) {
                return Str::endsWith(
                    $this->path(),
                    Documentation::pluck('slug')->map(fn ($slug) => $slug)->toArray()
                );
            }

            if (is_array($slug)) {
                return collect($slug)->contains(fn ($link) => $this->onDocs($link));
            }

            $path = $this->path();
            if (Str::contains($slug, '*')) {
                return Str::is('/'.ltrim($slug, '/'), '/'.$path);
            }

            if (Str::endsWith('/'.$path, '/'.ltrim($slug, '/'))) {
                return true;
            }

            if ($path === $slug) {
                return true;
            }

            if (Str::endsWith('/'.$path.'/intro', '/'.ltrim($slug, '/'))) {
                return true;
            }

            if ($checkGroup) {
                $pathSlash = strrpos($path, '/');
                $pathBase  = $pathSlash !== false ? substr($path, 0, $pathSlash) : $path;

                if (Str::endsWith('/'.$pathBase, '/'.ltrim($slug, '/'))) {
                    return true;
                }
            }

            return false;
        });

        Request::macro('onChildPage', function ($slug) {
            return Str::endsWith($slug, '/'.substr($this->path(), 0, strrpos($this->path(), '/')));
        });
    }
}

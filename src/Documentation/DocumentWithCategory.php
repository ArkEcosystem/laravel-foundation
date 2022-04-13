<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

use ARKEcosystem\Foundation\Documentation\Document as Base;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class DocumentWithCategory extends Base
{
    protected function getDocumentsFromDisk(string $type): array
    {
        $storage   =  Storage::disk($type);
        $documents = [];

        foreach ($storage->allFiles() as $file) {
            if (Str::endsWith($file, '.json')) {
                continue;
            }

            $body    = $storage->get($file);
            $content = YamlFrontMatter::parse($body);
            $slug    = $file === 'index.blade.php' ? 'index' : Str::replaceFirst('.md.blade.php', '', $file);

            $documents[] = [
                'id'         => md5($file),
                'type'       => $type,
                'category'   => explode('/', $file)[0],
                'name'       => $content->matter('title'),
                'number'     => $content->matter('number'),
                'slug'       => $slug,
                'body'       => $body,
                'updated_at' => DeriveGitCommitDate::execute($storage->path($file)),
            ];
        }

        return $documents;
    }

    protected function getNeighbour(string $direction, Closure $callback): ?self
    {
        $cacheKey = md5('documents.'.$this->slug.'.neighbour.'.$direction);

        return Cache::rememberForever($cacheKey, function () use ($callback) {
            $storage = Storage::disk($this->type);

            if ($storage->exists($this->category.'/index.blade.php')) {
                $content = $storage->get($this->category.'/index.blade.php');
            } else {
                $content = $storage->get($this->category.'/index.md.blade.php');
            }

            $matches = [];

            $dom = new Dom();
            $dom->loadStr(view(['template' => $content])->render());

            foreach ($dom->find('a') as $link) {
                $matches[] = [
                    'name' => trim($link->innerText),
                    'link' => str_replace('/'.$this->type.'/', '', trim($link->getAttribute('href'))),
                ];
            }

            $matches = collect($matches)->unique('link')->values();

            $index = $matches->search(fn ($match) => Str::endsWith($match['link'], $this->slug));

            $callbackValue = $callback($index);

            if ($callbackValue < 0 || $callbackValue >= count($matches)) {
                return;
            }

            return static::query()
                ->where('type', $this->type)
                ->where('category', $this->category)
                ->where('slug', $matches[$callback($index)]['link'])
                ->first();
        });
    }
}

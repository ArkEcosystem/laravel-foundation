<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

use ARKEcosystem\Foundation\CommonMark\Facades\Markdown;
use ARKEcosystem\Foundation\Documentation\Document as Base;
use Closure;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPHtmlParser\Dom;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class DocumentWithCategory extends Base
{
    /**
     * @var int
     */
    public const LIMIT = 256;

    protected function getDocumentsFromDisk(string $type): array
    {
        $storage   =  Storage::disk($type);
        $documents = [];

        foreach ($storage->allFiles() as $file) {
            if (! str_ends_with($file, '.php')) {
                continue;
            }

            $documents[] = $this->getDocumentFromDisk($storage, $file, $type);
        }

        return $documents;
    }

    protected function getDocumentFromDisk(Filesystem $storage, string $file, string $type): array
    {
        $body    = $storage->get($file);
        $content = YamlFrontMatter::parse($body);
        $slug    = $file === 'index.blade.php' ? 'index' : Str::replaceFirst('.md.blade.php', '', $file);

        return [
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

    protected function attributeExcerpt(string $value, int $limit = self::LIMIT): string
    {
        // Get HTML
        $value = $this->attributeHtmlContent($value);
        // Remove HTML tags
        $value = strip_tags(htmlspecialchars_decode($value));
        // Remove new lines
        $value = (string) preg_replace("#(^[\r\n]*|[\r\n]+)[\\s\t]*[\r\n]+#", '', $value);
        // Limit length
        return Str::limit($value, $limit);
    }

    protected function attributeHtmlContent(string $value): string
    {
        // Remove spaces
        $value = trim($value);
        // Remove FrontMatter
        $value = YamlFrontMatter::parse($value)->body();
        // Convert to HTML
        return (string) Markdown::convertToHtml($value);
    }
}

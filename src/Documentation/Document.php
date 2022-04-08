<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

use ARKEcosystem\Foundation\CommonMark\Facades\Markdown;
use ARKEcosystem\Foundation\Documentation\Concerns\CanBeShared;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use League\CommonMark\MarkdownConverterInterface;
use PHPHtmlParser\Dom;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Sushi\Sushi;

/**
 * @property string $slug
 * @property string $category
 * @property string $body
 * @property string $name
 * @property string $type
 * @property int|null $faq_index
 * @property string|null $faq_title
 * @property string|null $faq_description
 */
class Document extends Model
{
    use CanBeShared;
    use Sushi;

    /**
     * @var int
     */
    public const LIMIT = 256;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'faq_index' => 'integer',
    ];

    public static function docsCategories(): array
    {
        return static::type('docs')
            ->get(['category'])
            ->unique('category')
            ->pluck('category')
            ->values()
            ->toArray();
    }

    public static function findBySlug(string $slug): self
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    public function previous(): ?self
    {
        return $this->getNeighbour('previous', fn ($value) => $value - 1);
    }

    public function next(): ?self
    {
        return $this->getNeighbour('next', fn ($value) => $value + 1);
    }

    public function hasPrevious(): bool
    {
        // @TODO: hack - fix it
        return false;

        return ! empty($this->previous());
    }

    public function hasNext(): bool
    {
        // @TODO: hack - fix it
        return false;

        return ! empty($this->next());
    }

    public function url(): string
    {
        if ($this->type === 'tutorials') {
            return route('tutorial', $this->slug);
        }

        return route('documentation', $this->slug);
    }

    public function scopeSlug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeCategories(Builder $query, array $categories): Builder
    {
        return $query->whereIn('category', $categories);
    }

    public function scopeTerm(Builder $query, string $term): Builder
    {
        return $query->where(
            fn ($query) => $query->where('body', 'like', '%'.$term.'%')->whereNotNull('name')
        );
    }

    public function scopeFaq(Builder $query): Builder
    {
        /* @phpstan-ignore-next-line | dynamic call to static method `whereNotNull` */
        return $query->whereNotNull('faq_index');
    }

    public function faqId(): int | null
    {
        return $this->faq_index;
    }

    public function faqTitle(): string
    {
        return $this->faq_title ?? $this->name;
    }

    public function faqDescription(): string
    {
        return $this->faq_description ?? $this->excerpt();
    }

    public function nameWithHighlight(string $term): string
    {
        return $this->attributeWithHighlight($this->name, $term);
    }

    public function bodyWithHighlight(string $term): string
    {
        return $this->attributeWithHighlight($this->body, $term);
    }

    public function excerpt(int $limit = self::LIMIT): string
    {
        return $this->attributeExcerpt($this->body, $limit);
    }

    public function getRows()
    {
        return Cache::rememberForever('documents.all', function () {
            $documents = $this->getDocumentsFromDisk('docs');

            if (! config('filesystems.disks.tutorials')) {
                return $documents;
            }

            return array_merge($documents, $this->getDocumentsFromDisk('tutorials'));
        });
    }

    private function getDocumentsFromDisk(string $type): array
    {
        $storage   = Storage::disk($type);
        $documents = [];

        foreach ($storage->allFiles() as $file) {
            if (Str::endsWith($file, '.json')) {
                continue;
            }

            $body    = $storage->get($file);
            $content = YamlFrontMatter::parse($body);
            $slug    = $file === 'index.blade.php' ? 'index' : Str::replaceFirst('.md.blade.php', '', $file);

            $documents[] = [
                'id'              => md5($file),
                'faq_index'       => $content->matter('faq_index'),
                'faq_title'       => $content->matter('faq_title'),
                'faq_description' => $content->matter('faq_description'),
                'type'            => $type,
                'category'        => explode('/', $file)[0],
                'name'            => $content->matter('title'),
                'number'          => $content->matter('number'),
                'slug'            => $slug,
                'body'            => $body,
                'updated_at'      => DeriveGitCommitDate::execute($storage->path($file)),
            ];
        }

        return $documents;
    }

    private function getNeighbour(string $direction, Closure $callback): ?self
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
                ->where('slug', 'like', '%'.$matches[$callback($index)]['link'].'%')
                ->first();
        });
    }

    private function attributeWithHighlight(string $value, string $term): string
    {
        // Remove spaces
        $value = trim($value);
        // Remove FrontMatter
        $value = YamlFrontMatter::parse($value)->body();
        // Convert to Markdown
        $value = app(MarkdownConverterInterface::class)->convertToHtml($value)->getContent();
        // Remove HTML
        $value = strip_tags(htmlspecialchars_decode($value));
        // Remove new lines
        $value = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", '', $value);
        // Limit length
        $value = Str::limit($value, 256);
        // Highlight
        $value = preg_replace("/\b([a-z]*${term}[a-z]*)\b/i", '<span class="bg-theme-warning-100">$1</span>', $value);

        return $value;
    }

    private function attributeExcerpt(string $value, int $limit = self::LIMIT): string
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

    private function attributeHtmlContent(string $value): string
    {
        // Remove spaces
        $value = trim($value);
        // Remove FrontMatter
        $value = YamlFrontMatter::parse($value)->body();
        // Convert to HTML
        return (string) Markdown::convertToHtml($value);
    }
}

<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Models;

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Factories\ArticleFactory;
use ARKEcosystem\Foundation\CommonMark\Facades\Markdown;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\ResponseCache\Facades\ResponseCache;

/**
 * @property int $id
 */
final class Article extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'category'     => Category::class,
        'published_at' => 'datetime',
    ];

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function excerpt(int $length) : string
    {
        $excerpt = Markdown::convert($this->body);

        // Remove the # that gets added in front of headings
        $excerpt = str_replace('>#</a>', '></a>', (string) $excerpt);
        $excerpt = trim(strip_tags($excerpt));

        $words = explode(' ', $excerpt);

        if (count($words) > $length) {
            $excerpt = implode(' ', array_slice($words, 0, $length)).'...';
        }

        return $excerpt;
    }

    public function getReadingTimeAttribute() : int
    {
        return intval(ceil(str_word_count($this->body) / 230));
    }

    public function shareUrlReddit() : string
    {
        return sprintf('https://www.reddit.com/submit?title=%s&url=%s', urlencode($this->title), $this->url());
    }

    public function shareUrlTwitter() : string
    {
        return sprintf('https://twitter.com/intent/tweet?text=%s&url=%s', urlencode($this->title), $this->url());
    }

    public function shareUrlFacebook() : string
    {
        return 'https://www.facebook.com/sharer/sharer.php?u='.$this->url();
    }

    public static function featured() : ?self
    {
        return static::published()
                ->latest('published_at')
                ->first();
    }

    public function scopePublished(Builder $query) : Builder
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeSearch(Builder $query, string $term) : Builder
    {
        return $query->where(function (Builder $query) use ($term) {
            return $query->where('title', 'ilike', '%'.$term.'%')
                        ->orWhere('body', 'ilike', '%'.$term.'%')
                        ->orWhere('category', 'ilike', '%'.$term.'%');
        });
    }

    public function url() : string
    {
        return route('article', $this);
    }

    public function isPublished() : bool
    {
        return optional($this->published_at)->isPast() ?? false;
    }

    public function banner() : string
    {
        $banner = $this->getFirstMediaUrl('banner');

        if ($banner === '') {
            return '/images/vendor/ark/article/placeholder-banner.png';
        }

        return $banner;
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('banner')->singleFile();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function newFactory(): Factory
    {
        return new ArticleFactory();
    }

    protected static function booted() : void
    {
        self::created(function () {
            ResponseCache::clear();
        });

        self::updated(function () {
            ResponseCache::clear();
        });

        self::deleted(function () {
            ResponseCache::clear();
        });
    }
}

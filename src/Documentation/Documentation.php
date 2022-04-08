<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Documentation;

use ARKEcosystem\Foundation\Documentation\Concerns\CanBeShared;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Documentation extends Model
{
    use CanBeShared;
    use Sushi;

    protected $casts = [
        'is_coming_soon' => 'bool',
    ];

    public static function availableSDK(): array
    {
        return [
            ['name' => 'Typescript', 'slug' => 'typescript', 'has_complementary' => true],
            ['name' => 'PHP', 'slug' => 'php', 'has_complementary' => false],
            ['name' => 'Python', 'slug' => 'python', 'has_complementary' => true],
            ['name' => 'Java', 'slug' => 'java', 'has_complementary' => true],
            ['name' => 'Go', 'slug' => 'go', 'has_complementary' => false],
            ['name' => 'C++', 'slug' => 'c++', 'has_complementary' => true],
        ];
    }

    public static function deprecatedSDK(): array
    {
        return [
            ['name' => '.NET', 'slug' => 'dotnet', 'has_complementary' => false],
            ['name' => 'Elixir', 'slug' => 'elixir', 'has_complementary' => false],
            ['name' => 'Ruby', 'slug' => 'ruby', 'has_complementary' => false],
            ['name' => 'Rust', 'slug' => 'rust', 'has_complementary' => false],
            ['name' => Swift::class, 'slug' => 'swift', 'has_complementary' => false],
        ];
    }

    public static function productMenu(): array
    {
        return static::primary()->get()->map(fn ($documentation) => [
            'name'           => trans('menus.documentation.'.$documentation->slug),
            'slug'           => $documentation->slug,
            'is_coming_soon' => $documentation->is_coming_soon,
        ])->toArray();
    }

    public function url(): string
    {
        return route('documentation', $this->slug);
    }

    public function isComingSoon(): bool
    {
        return $this->is_coming_soon;
    }

    public function scopePrimary(Builder $builder): Builder
    {
        return $builder->where('is_quick_access', false);
    }

    public function scopeQuickAccess(Builder $builder): Builder
    {
        return $builder->where('is_quick_access', true);
    }

    public function getRows(): array
    {
        return [
            // Primary
            [
                'id'              => 1,
                'title'           => 'SDK',
                'slug'            => 'sdk',
                'description'     => null,
                'ticker'          => null,
                'logo'            => 'sdk',
                'is_coming_soon'  => false,
                'is_quick_access' => false,
            ], [
                'id'              => 2,
                'title'           => 'Wallet',
                'slug'            => 'wallet',
                'description'     => null,
                'ticker'          => null,
                'logo'            => 'wallet',
                'is_coming_soon'  => false,
                'is_quick_access' => false,
            ], [
                'id'              => 3,
                'title'           => 'Market Data API',
                'slug'            => 'market-data-api',
                'description'     => null,
                'ticker'          => null,
                'logo'            => 'market-data-api',
                'is_coming_soon'  => true,
                'is_quick_access' => false,
            ], [
                'id'              => 4,
                'title'           => 'ID',
                'slug'            => 'id',
                'description'     => null,
                'ticker'          => null,
                'logo'            => 'id',
                'is_coming_soon'  => true,
                'is_quick_access' => false,
            ],
            // Quick Access
            [
                'id'              => 5,
                'title'           => 'ARK',
                'slug'            => 'sdk/coins/ark',
                'description'     => null,
                'ticker'          => 'ARK',
                'logo'            => 'ark',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ],
        ];
    }
}

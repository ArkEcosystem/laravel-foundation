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
            ], [
                'id'              => 6,
                'title'           => 'Avalanche',
                'slug'            => 'sdk/coins/avax',
                'description'     => null,
                'ticker'          => 'AVAX',
                'logo'            => 'avalanche',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 7,
                'title'           => 'Bitcoin',
                'slug'            => 'sdk/coins/btc',
                'description'     => null,
                'ticker'          => 'BTC',
                'logo'            => 'bitcoin',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 8,
                'title'           => 'Cardano',
                'slug'            => 'sdk/coins/ada',
                'description'     => null,
                'ticker'          => 'ADA',
                'logo'            => 'cardano',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 9,
                'title'           => 'Cosmos',
                'slug'            => 'sdk/coins/atom',
                'description'     => null,
                'ticker'          => 'ATOM',
                'logo'            => 'cosmos',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 10,
                'title'           => 'Elrond',
                'slug'            => 'sdk/coins/egld',
                'description'     => null,
                'ticker'          => 'EGLD',
                'logo'            => 'elrond',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 11,
                'title'           => 'EOS',
                'slug'            => 'sdk/coins/eos',
                'description'     => null,
                'ticker'          => 'EOS',
                'logo'            => 'eos',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 12,
                'title'           => 'Ethereum',
                'slug'            => 'sdk/coins/eth',
                'description'     => null,
                'ticker'          => 'ETH',
                'logo'            => 'ethereum',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 13,
                'title'           => 'Lisk',
                'slug'            => 'sdk/coins/lsk',
                'description'     => null,
                'ticker'          => 'LSK',
                'logo'            => 'lisk',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 14,
                'title'           => 'Nano',
                'slug'            => 'sdk/coins/nano',
                'description'     => null,
                'ticker'          => 'NANO',
                'logo'            => 'nano',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 15,
                'title'           => 'Neo',
                'slug'            => 'sdk/coins/neo',
                'description'     => null,
                'ticker'          => 'NEO',
                'logo'            => 'neo',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 16,
                'title'           => 'Polkadot',
                'slug'            => 'sdk/coins/dot',
                'description'     => null,
                'ticker'          => 'DOT',
                'logo'            => 'polkadot',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 17,
                'title'           => 'Ripple',
                'slug'            => 'sdk/coins/xrp',
                'description'     => null,
                'ticker'          => 'XRP',
                'logo'            => 'ripple',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 18,
                'title'           => 'Solana',
                'slug'            => 'sdk/coins/sol',
                'description'     => null,
                'ticker'          => 'SOL',
                'logo'            => 'solana',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 19,
                'title'           => 'Stellar',
                'slug'            => 'sdk/coins/xlm',
                'description'     => null,
                'ticker'          => 'XLM',
                'logo'            => 'stellar',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 20,
                'title'           => 'Terra',
                'slug'            => 'sdk/coins/luna',
                'description'     => null,
                'ticker'          => 'LUNA',
                'logo'            => 'terra',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 21,
                'title'           => 'TRON',
                'slug'            => 'sdk/coins/trx',
                'description'     => null,
                'ticker'          => 'TRX',
                'logo'            => 'tron',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ], [
                'id'              => 22,
                'title'           => 'Zilliqa',
                'slug'            => 'sdk/coins/zil',
                'description'     => null,
                'ticker'          => 'ZIL',
                'logo'            => 'zilliqa',
                'is_coming_soon'  => false,
                'is_quick_access' => true,
            ],
        ];
    }
}

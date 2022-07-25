<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Models\Factories;

use ARKEcosystem\Foundation\Blog\Enums\Category;
use ARKEcosystem\Foundation\Blog\Models\Article;
use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'      => User::factory(),
            'category'     => Arr::random(Category::cases()),
            'title'        => $title = $this->faker->sentence(),
            'slug'         => Str::slug($title),
            'body'         => $this->faker->paragraph(),
            'published_at' => now()->subDays(random_int(1, 20)),
        ];
    }
}

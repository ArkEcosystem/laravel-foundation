<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Models\Article;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;

final class Articles extends Component
{
    public ?string $search = null;

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.articles');
    }

    public function getArticlesProperty(): LengthAwarePaginator
    {
        $articles = null;
        if ($this->search) {
            $articles = Article::search($this->search)->latest();
        } else {
            $articles = Article::latest();
        }

        return $articles->paginate();
    }
}

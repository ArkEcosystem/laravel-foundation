<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Controllers;

use ARKEcosystem\Foundation\Blog\Models\Article;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

final class ArticleController
{
    public function index(Request $request) : Renderable
    {
        return view('ark::pages.blog.index', [
            'request' => $request,
        ]);
    }

    public function show(Article $article) : Renderable
    {
        abort_unless($article->isPublished(), 404);

        return view('ark::pages.blog.article', [
            'article'  => $article,
            'articles' => Article::published()
                        ->where('id', '!=', $article->id)
                        ->latest('published_at')
                        ->limit(3)
                        ->get(),
        ]);
    }
}

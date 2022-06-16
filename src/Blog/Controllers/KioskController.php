<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Controllers;

use ARKEcosystem\Foundation\Blog\Models\Article;
use Illuminate\Contracts\Support\Renderable;

final class KioskController
{
    public function index() : Renderable
    {
        return view('ark::pages.blog.kiosk.articles');
    }

    public function show(Article $article) : Renderable
    {
        return view('ark::pages.blog.kiosk.article', [
            'article' => $article,
        ]);
    }
}

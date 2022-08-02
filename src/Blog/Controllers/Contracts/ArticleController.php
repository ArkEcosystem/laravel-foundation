<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Controllers\Contracts;

use ARKEcosystem\Foundation\Blog\Models\Article;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

interface ArticleController
{
    public function index(Request $request): Renderable;

    public function show(Article $article): Renderable;
}

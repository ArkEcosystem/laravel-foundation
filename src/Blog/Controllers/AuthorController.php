<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Controllers;

use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

final class AuthorController extends BaseController
{
    public function __invoke(Request $request, User $author) : Renderable
    {
        return view('ark::pages.blog.author', [
            'request' => $request,
            'author'  => $author,
        ]);
    }
}

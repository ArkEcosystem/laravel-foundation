<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Controllers;

use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller as BaseController;

final class AuthorController extends BaseController
{
    public function __invoke(User $author) : Renderable
    {
        return view('app.author', [
            'author' => $author,
        ]);
    }
}

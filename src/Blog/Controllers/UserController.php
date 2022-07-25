<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Controllers;

use ARKEcosystem\Foundation\Blog\Models\User;
use Illuminate\Contracts\Support\Renderable;

final class UserController
{
    public function index() : Renderable
    {
        return view('ark::pages.blog.kiosk.users', [
            'users' => User::orderBy('name')->paginate(),
        ]);
    }

    public function edit(User $user) : Renderable
    {
        return view('ark::pages.blog.kiosk.user', [
            'user' => $user,
        ]);
    }
}

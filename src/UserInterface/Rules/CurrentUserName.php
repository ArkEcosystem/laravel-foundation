<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class CurrentUserName implements Rule
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value)
    {
        return $this->user->name === $value;
    }

    public function message()
    {
        return Lang::get('validation.messages.current_name');
    }
}

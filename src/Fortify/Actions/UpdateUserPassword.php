<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Actions;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * Validate and update the user's password.
     *
     * @param mixed $user
     * @param array $input
     *
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'current_password'      => ['required', 'string'],
            'password'              => $this->passwordRules(),
            'password_confirmation' => $this->passwordConfirmationRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (! Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', trans('ui::validation.password_doesnt_match'));
            }

            if (Hash::check($input['password'], $user->password)) {
                $validator->errors()->add('password', trans('ui::validation.password_current'));
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}

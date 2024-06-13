<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Foundation\Fortify\Contracts\DeleteUser;
use ARKEcosystem\Foundation\Fortify\Mail\SendFeedback;
use ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns\HasModal;
use ARKEcosystem\Foundation\UserInterface\Rules\CurrentPassword;
use ARKEcosystem\Foundation\UserInterface\Rules\CurrentUserName;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class DeleteUserForm extends Component
{
    use HasModal;
    use InteractsWithUser;

    public bool $confirmPassword = true;

    public bool $confirmName = false;

    public string $confirmedPassword = '';

    public string $confirmedName = '';

    public string $feedback = '';

    public bool $showConfirmationMessage = true;

    public string $alertType = 'info';

    public ?string $alert = null;

    public ?string $icon = null;

    public function confirmUserDeletion()
    {
        $this->dispatch('confirming-delete-user');

        $this->openModal();
    }

    public function updated(string $property): void
    {
        $this->clearValidation($property);
    }

    public function deleteUser(DeleteUser $deleter, StatefulGuard $auth)
    {
        $this->validate();

        $redirect = $this->sendFeedback();

        $deleter->delete($this->user->fresh());

        $auth->logout();

        $this->redirect($redirect);
    }

    public function render()
    {
        return view('ark-fortify::profile.delete-user-form');
    }

    protected function rules(): array
    {
        $rules = [
            'feedback' => 'present|string|min:5|max:500',
        ];

        if ($this->confirmPassword) {
            $rules['confirmedPassword'] = ['required', new CurrentPassword($this->user)];
        }

        if ($this->confirmName) {
            $rules['confirmedName'] = ['required', new CurrentUserName($this->user)];
        }

        return $rules;
    }

    private function sendFeedback(): string
    {
        if ($this->feedback !== '' && $this->validate()) {
            Mail::to(config('fortify.mail.feedback.address'))->send(new SendFeedback($this->feedback));

            return URL::temporarySignedRoute('profile.feedback.thank-you', now()->addMinutes(15));
        }

        return route('home');
    }
}

<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Models\User;
use ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns\HasModal;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

final class DeleteUser extends Component
{
    use HasModal;

    public ?User $user;

    public ?string $userEmailConfirmation = null;

    /** @var mixed */
    protected $listeners = ['triggerUserDelete' => 'open'];

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.delete-user');
    }

    public function open(int $id): void
    {
        abort_if(Auth::guest(), 404);

        $this->user = User::findOrFail($id);

        $this->openModal();
    }

    public function close(): void
    {
        $this->resetErrorBag();

        $this->user                  = null;
        $this->userEmailConfirmation = null;

        $this->closeModal();
    }

    public function updatedUserEmailConfirmation(): void
    {
        /** @var string $email */
        $email = $this->user?->email;

        $this->validate([
            'userEmailConfirmation' => ['present', Rule::in($email)],
        ]);
    }

    public function getCanSubmitProperty(): bool
    {
        return ! is_null($this->userEmailConfirmation) && $this->userEmailConfirmation !== '' && $this->getErrorBag()->count() === 0;
    }

    public function deleteUser(): void
    {
        abort_if(Auth::guest(), 404);

        if ($this->getCanSubmitProperty()) {
            /** @var User $user */
            $user = $this->user;

            $user->delete();

            $this->close();

            $this->redirect(route('kiosk.users'));
        }
    }
}

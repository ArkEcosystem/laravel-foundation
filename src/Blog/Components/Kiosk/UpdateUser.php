<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Models\User;
use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleToast;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

final class UpdateUser extends Component
{
    use HandleToast;
    use WithFileUploads;

    public User $user;

    public array $state = [
        'name'             => '',
        'email'            => '',
        'password'         => '',
        'photo'            => '',
    ];

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.update-user');
    }

    public function mount(User $user) : void
    {
        $this->user = $user;

        $this->state = $user->withoutRelations()->toArray() + [
            'password' => '',
            'photo'    => '',
        ];
    }

    public function save() : void
    {
        $this->validate([
            'state.name'            => ['required', 'string', 'max:255'],
            'state.email'           => ['required', 'string', Rule::unique('users', 'email')->ignore($this->user)],
            'state.password'        => ['nullable', 'string'],
            'state.photo'           => ['nullable', 'image'],
        ]);

        $this->user->update([
            'name'     => $this->state['name'],
            'email'    => $this->state['email'],
            'password' => $this->state['password'] !== '' ? Hash::make($this->state['password']) : $this->user->password,
        ]);

        if ($this->state['photo'] !== null && $this->state['photo'] !== '') {
            $uploadedFile = $this->state['photo'];
            $uploadedFile = new UploadedFile($uploadedFile->path(), $uploadedFile->getClientOriginalName());
            $this->user->addMedia($uploadedFile)->toMediaCollection('photo');
        }

        $this->toast('The user has been updated.');

        $this->redirectRoute('kiosk.users');
    }
}

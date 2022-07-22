<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Kiosk;

use ARKEcosystem\Foundation\Blog\Models\User;
use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleToast;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

final class CreateUser extends Component
{
    use HandleToast;
    use WithFileUploads;

    public array $state = [
        'name'             => '',
        'email'            => '',
        'password'         => '',
        'photo'            => '',
    ];

    public function render(): Renderable
    {
        return view('ark::components.blog.kiosk.create-user');
    }

    public function save() : void
    {
        $this->validate([
            'state.name'          => ['required', 'string', 'max:255'],
            'state.email'         => ['required', 'string', 'unique:users,email'],
            'state.password'      => ['required', 'string'],
            'state.photo'         => ['required', 'image'],
        ]);

        $user = User::create([
            'name'     => $this->state['name'],
            'email'    => $this->state['email'],
            'password' => Hash::make($this->state['password']),
        ]);

        $uploadedFile = $this->state['photo'];
        $uploadedFile = new UploadedFile($uploadedFile->path(), $uploadedFile->getClientOriginalName());
        $user->addMedia($uploadedFile)->toMediaCollection('photo');

        $this->redirectRoute('kiosk.users');
    }
}

<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use Livewire\Attributes\Isolate;
use Livewire\Attributes\On;
use Livewire\Component;

#[Isolate]
class Toast extends Component
{
    public $toasts = [];

    public function render()
    {
        return view('ark::livewire.toast', [
            'toasts' => $this->toasts,
        ]);
    }

    #[On('toastMessage')]
    public function handleIncomingMessage(string $message, string $type): void
    {
        $this->toasts[uniqid()] = [
            'message' => $message,
            'type'    => $type,
        ];
    }

    #[On('dismissToast')]
    public function dismissToast(string $id): void
    {
        unset($this->toasts[$id]);
    }
}

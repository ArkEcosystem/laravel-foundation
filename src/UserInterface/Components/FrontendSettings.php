<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class FrontendSettings extends Component
{
    public array $state = [];

    protected array $defaultSettings = [
        'darkTheme' => false,
    ];

    protected $listeners = [
        'settings.toggle-dark-mode' => 'toggleDarkMode',
    ];

    public function mount(): void
    {
        $this->state = $this->cookieSettings();
    }

    public function render()
    {
        return '<div></div>';
    }

    public function toggleDarkMode(): void
    {
        $this->state['darkTheme'] = ! $this->state['darkTheme'];
        $this->saveSettings();
    }

    private function cookieSettings(): array
    {
        $sessionSettings = [];
        if (Cookie::has('settings')) {
            $sessionSettings = json_decode(strval(Cookie::get('settings')), true);
        }

        return $sessionSettings + $this->defaultSettings;
    }

    private function saveSettings(): void
    {
        $originalTheme = Arr::get($this->cookieSettings(), 'darkTheme');
        $newTheme      = Arr::get($this->state, 'darkTheme');

        Cookie::queue('settings', json_encode($this->state), 60 * 24 * 365 * 5);

        if ($originalTheme !== $newTheme) {
            $this->dispatchBrowserEvent('setThemeMode', [
                'theme' => $newTheme === true ? 'dark' : 'light',
            ]);
        }
    }
}

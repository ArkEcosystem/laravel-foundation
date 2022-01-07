<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class FrontendSettings extends Component
{
    public array $state = [];

    protected array $defaultSettings = [
        'darkTheme' => false,
    ];

    protected $listeners = [
        'settings.set-dark-mode' => 'setDarkMode',
    ];

    public function mount(): void
    {
        $this->state = $this->cookieSettings();
    }

    public function render()
    {
        return '<div></div>';
    }

    public function setDarkMode(bool $darkMode = false): void
    {
        $this->state['darkTheme'] = $darkMode;
        $this->saveSettings();

        $this->dispatchBrowserEvent('setThemeMode', [
            'theme' => $darkMode === true ? 'dark' : 'light',
        ]);
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
        Cookie::queue('settings', json_encode($this->state), 60 * 24 * 365 * 5);
    }
}

<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Foundation\Support\Timezone;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UpdateTimezoneForm extends Component
{
    use InteractsWithUser;

    public $timezone;

    /**
     * Mount the component.
     */
    public function mount()
    {
        $this->timezone = $this->user->timezone;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-timezone-form');
    }

    public function updateTimezone(): void
    {
        $data = $this->validate([
            'timezone' => [
                'required',
                Rule::in(Timezone::list()),
            ],
        ]);

        $this->user->timezone = $data['timezone'];

        $this->user->save();

        $this->dispatch('toastMessage', [trans('ui::pages.user-settings.timezone_updated'), 'success']);
    }
}

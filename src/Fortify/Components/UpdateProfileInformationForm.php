<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfileInformationForm extends Component
{
    use InteractsWithUser;
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
    }

    /**
     * Update the user's profile information.
     *
     * @param \Laravel\Fortify\Contracts\UpdatesUserProfileInformation $updater
     *
     * @return void
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), $this->state);

        $this->dispatch('saved');

        $this->dispatch('refresh-navigation-dropdown');

        $this->dispatch('toastMessage', [trans('ui::pages.user-settings.profile_updated'), 'success']);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-profile-information-form');
    }
}

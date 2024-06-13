<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns\HasModal;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class LogoutOtherBrowserSessionsForm extends Component
{
    use HasModal;

    public String $password = '';

    public function render(): View
    {
        return view('ark-fortify::profile.logout-other-browser-sessions-form');
    }

    public function confirmLogout(): void
    {
        $this->password = '';

        $this->openModal();
    }

    public function updatedPassword()
    {
        $this->resetErrorBag();
    }

    public function logoutOtherBrowserSessions(StatefulGuard $guard): void
    {
        $this->resetErrorBag();

        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [trans('ui::validation.password_doesnt_match_records')],
            ]);
        }

        $guard->logoutOtherDevices($this->password);

        $this->deleteOtherSessionRecords();

        $this->closeModal();

        $this->dispatch('loggedOut');
    }

    public function getSessionsProperty(): Collection
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::table('sessions')
                    ->where('user_id', Auth::user()->getKey())
                    ->orderBy('last_activity', 'desc')
                    ->take(3)->get()
        )->map(function ($session) {
            return (object) [
                'agent'             => $this->createAgent($session),
                'ip_address'        => $session->ip_address,
                'is_current_device' => $session->id === session()->getId(),
                'last_active'       => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    protected function deleteOtherSessionRecords(): void
    {
        if (config('session.driver') !== 'database') {
            return;
        }

        DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', Auth::user()->getKey())
            ->where('id', '!=', session()->getId())
            ->delete();
    }

    protected function createAgent(mixed $session): Agent
    {
        return tap(new Agent(), function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }
}

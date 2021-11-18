<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\ValidatesPassword;
use ARKEcosystem\Foundation\Fortify\Models;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Livewire\Component;

class RegisterForm extends Component
{
    use ValidatesPassword;

    public ?string $name = '';

    public ?string $username = '';

    public ?string $email = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    public bool $terms = false;

    public string $formUrl;

    public ?string $invitationId = null;

    protected array $requiredProperties = [
        'name',
        'username',
        'email',
        'password',
        'password_confirmation',
        'terms',
    ];

    public function mount()
    {
        $this->name     = old('name', '');
        $this->username = old('username', '');
        $this->email    = old('email', '');
        $this->terms    = old('terms', false) === true;

        $this->formUrl = request()->fullUrl();

        $this->invitationId = request()->get('invitation');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.register-form', [
            'invitation' => $this->invitationId ? Models::invitation()::findByUuid($this->invitationId) : null,
        ]);
    }

    public function canSubmit(): bool
    {
        foreach ($this->requiredProperties as $property) {
            if (! $this->$property) {
                return false;
            }
        }

        return $this->getErrorBag()->count() === 0;
    }

    public function updated(string $propertyName, mixed $value): void
    {
        if ($propertyName === 'email') {
            $value = strtolower($value);
        }

        $values = [$propertyName => $value];
        $rules  = [$propertyName => $this->rules()[$propertyName]];

        if ($propertyName === 'password') {
            $values['password_confirmation'] = $this->password_confirmation;
            $rules['password_confirmation']  = $this->rules()['password_confirmation'];

            $this->resetErrorBag([$propertyName, 'password_confirmation']);
        } elseif ($propertyName === 'password_confirmation') {
            $values['password'] = $this->password;
        }

        $validator = Validator::make($values, $rules);

        if ($validator->fails()) {
            $this->setErrorBag(
                $validator->getMessageBag()->merge($this->getErrorBag())
            );

            return;
        }

        $this->resetErrorBag($propertyName);
    }

    protected function rules(): array
    {
        return collect(resolve(CreatesNewUsers::class)::createValidationRules())
            ->filter(fn ($value, $key) => property_exists($this, $key))
            ->toArray();
    }
}

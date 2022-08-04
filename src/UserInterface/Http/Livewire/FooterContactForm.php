<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Livewire;

use ARKEcosystem\Foundation\UserInterface\Components\Concerns\HandleToast;
use ARKEcosystem\Foundation\UserInterface\Mail\ContactFormSubmitted;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Spatie\Honeypot\Http\Livewire\Concerns\HoneypotData;
use Spatie\Honeypot\Http\Livewire\Concerns\UsesSpamProtection;

final class FooterContactForm extends Component
{
    use HandleToast;
    use UsesSpamProtection;

    public HoneypotData $extraFields;

    public array $state = [
        'name'    => '',
        'email'   => '',
        'message' => '',
    ];

    public function mount() : void
    {
        $this->extraFields = new HoneypotData();
    }

    public function render() : Renderable
    {
        return view('ark::livewire.footer-contact-form');
    }

    public function send() : void
    {
        $this->protectAgainstSpam();

        Validator::make([
            'contact:name'    => $this->state['name'],
            'contact:email'   => $this->state['email'],
            'contact:message' => $this->state['message'],
        ], rules: $this->validationRules(), messages: $this->validationMessages())->validate();

        Mail::send(new ContactFormSubmitted(array_merge($this->state, [
            'subject' => trans('ui::pages.extended-footer.contact.subject'),
        ])));

        $this->toast(trans('ui::pages.extended-footer.contact.success'));
        $this->resetForm();
    }

    private function resetForm() : void
    {
        $this->state = [
            'name'    => '',
            'email'   => '',
            'message' => '',
        ];
    }

    private function validationRules() : array
    {
        return [
            'contact:name'    => ['required', 'max:64'],
            'contact:email'   => ['required', 'email'],
            'contact:message' => ['required', 'max:2048'],
        ];
    }

    private function validationMessages() : array
    {
        return [
            '*.required'          => trans('ui::validation.extended-footer-contact.required'),
            'contact:name.max'    => trans('ui::validation.extended-footer-contact.max'),
            'contact:email.email' => trans('ui::validation.extended-footer-contact.email'),
            'contact:message.max' => trans('ui::validation.extended-footer-contact.max'),
        ];
    }
}

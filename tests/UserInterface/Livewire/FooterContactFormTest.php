<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Http\Livewire\FooterContactForm;
use ARKEcosystem\Foundation\UserInterface\Mail\ContactFormSubmitted;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(function () {
    config([
        'honeypot.enabled' => false,
    ]);
});

it('should render', function () {
    Livewire::test(FooterContactForm::class)
        ->assertSee(trans('ui::pages.extended-footer.contact.title'))
        ->assertSee(trans('ui::pages.extended-footer.contact.description'), false)
        ->assertSeeHtml('type="text" id="contact:name" name="contact:name" autocapitalize="none"');
});

it('should setup state', function () {
    Livewire::test(FooterContactForm::class)
        ->assertSet('state.name', '')
        ->assertSet('state.email', '')
        ->assertSet('state.message', '');
});

it('should send', function () {
    Mail::fake();

    Livewire::test(FooterContactForm::class)
        ->set('state.name', 'Bob')
        ->set('state.email', 'bob@ark.io')
        ->set('state.message', 'Testing')
        ->assertHasNoErrors()
        ->call('send');

    Mail::assertQueued(ContactFormSubmitted::class);
});

it('should clear fields on send', function () {
    Mail::fake();

    Livewire::test(FooterContactForm::class)
        ->assertSet('state', [
            'name'    => '',
            'email'   => '',
            'message' => '',
        ])
        ->set('state.name', 'Bob')
        ->set('state.email', 'bob@ark.io')
        ->set('state.message', 'Testing')
        ->call('send')
        ->assertHasNoErrors()
        ->assertSet('state', [
            'name'    => '',
            'email'   => '',
            'message' => '',
        ]);
});

it('should not clear fields on error', function () {
    Livewire::test(FooterContactForm::class)
        ->assertSet('state', [
            'name'    => '',
            'email'   => '',
            'message' => '',
        ])
        ->set('state.name', 'Bob')
        ->set('state.email', 'bob@ark.io')
        ->assertHasNoErrors()
        ->call('send')
        ->assertHasErrors()
        ->assertSet('state', [
            'name'    => 'Bob',
            'email'   => 'bob@ark.io',
            'message' => '',
        ]);
});

it('should validate fields on send', function () {
    Mail::fake();

    Livewire::test(FooterContactForm::class)
        ->set('state.name', '')
        ->set('state.email', 'bob')
        ->set('state.message', '')
        ->call('send')
        ->assertHasErrors([
            'contact:name',
            'contact:email',
            'contact:message',
        ])
        ->set('state.message', 'Testing')
        ->call('send')
        ->assertHasErrors([
            'contact:name',
            'contact:email',
        ])
        ->set('state.name', 'Bob')
        ->call('send')
        ->assertHasErrors([
            'contact:email',
        ])
        ->set('state.email', 'bob@ark.io')
        ->call('send')
        ->assertHasNoErrors();
});

it('should prevent requests too quickly', function () {
    Mail::fake();

    config([
        'honeypot.enabled' => true,
    ]);

    $this->withoutExceptionHandling();

    $component = Livewire::test(FooterContactForm::class);

    $component
        ->set('state.name', 'Bob')
        ->set('state.email', 'bob@bob.com')
        ->set('state.message', 'Testing 123')
        ->call('send')
        ->assertHasNoErrors();

    Mail::assertNotQueued(ContactFormSubmitted::class);

    $this->travel(3)->seconds();

    $component->call('send')->assertHasNoErrors();

    Mail::assertQueued(ContactFormSubmitted::class, 1);
})->throws('Spam detected.');

it('should prevent requests using honeypot', function () {
    Mail::fake();

    config([
        'honeypot.enabled' => true,
    ]);

    $component = Livewire::test(FooterContactForm::class);

    $component
        ->set('state.name', 'Bob')
        ->set('state.email', 'bob@bob.com')
        ->set('state.message', 'Testing 123')
        ->set('extraFields.my_name', 'Bob');

    $this->travel(3)->seconds();

    $component->instance()->send();

    Mail::assertNotQueued(ContactFormSubmitted::class);

    $component->set('extraFields.my_name', '')
        ->call('send')
        ->assertStatus(200);

    Mail::assertQueued(ContactFormSubmitted::class, 1);
})->throws('Spam detected.');

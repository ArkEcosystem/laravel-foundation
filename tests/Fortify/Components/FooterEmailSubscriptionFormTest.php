<?php

declare(strict_types=1);

namespace Tests\Components;

use ARKEcosystem\Foundation\Fortify\Components\FooterEmailSubscriptionForm;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;
use Spatie\Newsletter\Facades\Newsletter;
use function Tests\createUserModel;

it('can render form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(FooterEmailSubscriptionForm::class)
        ->assertSet('subscribed', false)
        ->assertSet('email', null)
        ->assertSet('status', null)
        ->assertViewIs('ark-fortify::newsletter.footer-subscription-form');
});

it('should handle duplicate entries', function () {
    Config::set('newsletter.apiKey', 'test-test');
    Config::set('newsletter.lists.subscribers.id', 'list-id');

    Newsletter::shouldReceive('isSubscribed')
        ->andReturn(true)
        ->once();

    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(FooterEmailSubscriptionForm::class)
        ->assertSet('subscribed', false)
        ->assertSet('email', null)
        ->assertSet('status', null)
        ->set('email', 'email@email.com')
        ->call('subscribe')
        ->assertSet('subscribed', false)
        ->assertSet('status', trans('ui::messages.subscription.duplicate'))
        ->assertViewIs('ark-fortify::newsletter.footer-subscription-form');
});

it('should handle subscription', function () {
    Config::set('newsletter.apiKey', 'test-test');
    Config::set('newsletter.lists.subscribers.id', 'list-id');

    Newsletter::shouldReceive('isSubscribed')
        ->andReturn(false)
        ->once();

    Newsletter::shouldReceive('subscribePending')
        ->andReturn(true)
        ->once();

    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(FooterEmailSubscriptionForm::class)
        ->assertSet('subscribed', false)
        ->assertSet('email', null)
        ->assertSet('status', null)
        ->set('email', 'email@email.com')
        ->call('subscribe')
        ->assertSet('subscribed', true)
        ->assertSet('status', trans('ui::messages.subscription.pending'))
        ->assertViewIs('ark-fortify::newsletter.footer-subscription-form');
});

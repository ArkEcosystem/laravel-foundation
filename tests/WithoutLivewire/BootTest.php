<?php

declare(strict_types=1);

use Livewire\LivewireServiceProvider;

it('should boot without livewire being loaded', function () {
    expect($this->app->providerIsLoaded(LivewireServiceProvider::class))->toBeFalse()
        ->and($this->app->bound('livewire.finder'))->toBeFalse();
});

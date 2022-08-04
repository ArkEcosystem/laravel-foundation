<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\ExportUserData;
use function Tests\createUserModel;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

it('can export the user data', function () {
    Bus::fake();

    Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export')
        ->assertEmitted('toastMessage', [trans('ui::pages.user-settings.data_exported'), 'success']);

    Bus::assertDispatched(CreatePersonalDataExportJob::class);
});

it('can only export the user data once every 15 min', function () {
    Bus::fake();

    $component = Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export')
        ->assertEmitted('toastMessage', [trans('ui::pages.user-settings.data_exported'), 'success'])
        ->call('export')
        ->assertNotEmitted('toastMessage', [trans('ui::pages.user-settings.data_exported'), 'success']);

    $this->travel(16)->minutes();

    $component->call('export')
        ->assertEmitted('toastMessage', [trans('ui::pages.user-settings.data_exported'), 'success']);

    Bus::assertDispatched(CreatePersonalDataExportJob::class);
});

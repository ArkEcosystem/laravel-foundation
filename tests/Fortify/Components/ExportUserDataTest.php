<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\ExportUserData;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;
use function Tests\createUserModel;

it('can export the user data', function () {
    Bus::fake();

    Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export')
        ->assertDispatched('toastMessage', [
            'message' => trans('ui::pages.user-settings.data_exported'),
            'type'    => 'success',
        ]);

    Bus::assertDispatched(CreatePersonalDataExportJob::class);
});

it('can only export the user data once every 15 min', function () {
    Bus::fake();

    $component = Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export')
        ->assertDispatched('toastMessage', [
            'message' => trans('ui::pages.user-settings.data_exported'),
            'type'    => 'success',
        ])
        ->call('export')
        ->assertNotDispatched('toastMessage', [
            'message' => trans('ui::pages.user-settings.data_exported'),
            'type'    => 'success',
        ]);

    $this->travel(16)->minutes();

    $component->call('export')
        ->assertDispatched('toastMessage', [
            'message' => trans('ui::pages.user-settings.data_exported'),
            'type'    => 'success',
        ]);

    Bus::assertDispatched(CreatePersonalDataExportJob::class);
});

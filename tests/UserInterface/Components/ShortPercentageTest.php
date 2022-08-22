<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\ShortPercentage;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 10.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 100.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 1000.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 10000.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 100000.12]));
    assertMatchesSnapshot((new ShortPercentage())->render()(['slot' => 1000000.12]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->view('short-percentage', ['slot' => 10.12])->assertSeeText('10%');
    $this->view('short-percentage', ['slot' => 100.12])->assertSeeText('100%');
    $this->view('short-percentage', ['slot' => 1000.12])->assertSeeText('1000%');
    $this->view('short-percentage', ['slot' => 10000.12])->assertSeeText('10000%');
    $this->view('short-percentage', ['slot' => 100000.12])->assertSeeText('100000%');
    $this->view('short-percentage', ['slot' => 1000000.12])->assertSeeText('1000000%');
});

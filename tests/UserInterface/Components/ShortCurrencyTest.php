<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\ShortCurrency;
use function Spatie\Snapshots\assertMatchesSnapshot;
use Illuminate\Support\Facades\View;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 10000000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 100000000000]));
    assertMatchesSnapshot((new ShortCurrency('USD'))->render()(['slot' => 1000000000000]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->view('short-currency', ['slot' => 10])->assertSeeText('10 USD');
    $this->view('short-currency', ['slot' => 100])->assertSeeText('100 USD');
    $this->view('short-currency', ['slot' => 1000])->assertSeeText('1K USD');
    $this->view('short-currency', ['slot' => 10000])->assertSeeText('10K USD');
    $this->view('short-currency', ['slot' => 100000])->assertSeeText('100K USD');
    $this->view('short-currency', ['slot' => 1000000])->assertSeeText('1M USD');
    $this->view('short-currency', ['slot' => 10000000])->assertSeeText('10M USD');
    $this->view('short-currency', ['slot' => 100000000])->assertSeeText('100M USD');
    $this->view('short-currency', ['slot' => 1000000000])->assertSeeText('1B USD');
    $this->view('short-currency', ['slot' => 10000000000])->assertSeeText('10B USD');
    $this->view('short-currency', ['slot' => 100000000000])->assertSeeText('100B USD');
    $this->view('short-currency', ['slot' => 1000000000000])->assertSeeText('1T USD');
});

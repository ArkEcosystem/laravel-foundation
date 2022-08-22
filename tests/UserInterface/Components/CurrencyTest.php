<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\Currency;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10000]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100000]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000000]));

    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 10000, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 100000, 'attributes' => ['decimals' => 0]]));
    assertMatchesSnapshot((new Currency('USD'))->render()(['slot' => 1000000, 'attributes' => ['decimals' => 0]]));
});

it('should render when included in a blade view', function (): void {
    $this->view('currency', ['slot' => 10])->assertSeeText('10 USD');
    $this->view('currency', ['slot' => 100])->assertSeeText('100 USD');
    $this->view('currency', ['slot' => 1000])->assertSeeText('1,000 USD');
    $this->view('currency', ['slot' => 10000])->assertSeeText('10,000 USD');
    $this->view('currency', ['slot' => 100000])->assertSeeText('100,000 USD');
    $this->view('currency', ['slot' => 1000000])->assertSeeText('1,000,000 USD');
});

it('should render with decimals when included in a blade view', function (): void {
    $this->view('currency-with-decimals', ['slot' => 0.012])->assertSeeText('0.01 USD');
});

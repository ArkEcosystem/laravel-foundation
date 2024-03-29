<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\TruncateMiddle;
use Illuminate\Support\Facades\View;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the given value', function (): void {
    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot' => 'I am a very long string',
    ]));

    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot'        => 'I am a very long string',
        ['attributes' => ['length' => 12]],
    ]));

    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot'        => 'I am a very long string',
        ['attributes' => ['length' => 1]],
    ]));

    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot' => 'short',
    ]));

    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot'        => 'a',
        ['attributes' => ['length' => 12]],
    ]));

    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot' => 'abcd',
    ]));

    assertMatchesSnapshot((new TruncateMiddle())->render()([
        'slot'        => 'abcdefghijklmnopqrstuvwxyz',
        ['attributes' => ['length' => 100]],
    ]));
});

it('should render when included in a blade view', function (): void {
    View::addLocation(realpath(__DIR__.'/../../blade-views'));

    $this->vieW('truncate-middle', ([
        'slot' => 'I am a very long string',
    ]))->assertSeeText('I am …tring');

    $this->vieW('truncate-middle-with-length', ([
        'slot'   => 'I am a very long string',
        'length' => 12,
    ]))->assertSeeText('I am a…string');

    $this->vieW('truncate-middle-with-length', ([
        'slot'   => 'I am a very long string',
        'length' => 2,
    ]))->assertSeeText('I…g');

    $this->vieW('truncate-middle', ([
        'slot' => 'short',
    ]))->assertSeeText('short');

    $this->vieW('truncate-middle-with-length', ([
        'slot'   => 'a',
        'length' => 12,
    ]))->assertSeeText('a');

    $this->vieW('truncate-middle', ([
        'slot' => 'abcd',
    ]))->assertSeeText('abcd');

    $this->vieW('truncate-middle-with-length', [
        'slot'   => 'abcdefghijklmnopqrstuvwxyz',
        'length' => 100,
    ])->assertSeeText('abcdefghijklmnopqrstuvwxyz');
});

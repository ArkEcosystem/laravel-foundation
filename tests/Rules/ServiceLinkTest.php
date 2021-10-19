<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('unknown');
});

it('should throw an exception for an unknown service', function () {
    $this->subject->passes('key', 'value');
})->throws(InvalidArgumentException::class, 'has no regular expression.');

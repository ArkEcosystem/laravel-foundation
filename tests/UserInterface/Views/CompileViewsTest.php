<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Providers\BlogServiceProvider;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\Finder\Finder;

beforeEach(fn () => $this->app->register(BlogServiceProvider::class));

it('should compile every view', function (string $path): void {
    expect(fn () => Blade::compileString(file_get_contents($path)))->not->toThrow(InvalidArgumentException::class);
})->with(function (): array {
    $views = Finder::create()->files()->in(__DIR__.'/../../../resources/views')->name('*.blade.php');

    return collect($views)->mapWithKeys(fn ($file) => [$file->getRelativePathname() => [$file->getRealPath()]])->all();
});

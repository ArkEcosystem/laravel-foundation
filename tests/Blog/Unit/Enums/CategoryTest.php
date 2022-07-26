<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Blog\Enums\Category;

it('can get class name', function () {
    expect(Category::News->className())->toBe('bg-theme-primary-600');
    expect(Category::Editorials->className())->toBe('bg-theme-success-600');
    expect(Category::Updates->className())->toBe('bg-theme-hint-600');
    expect(Category::Tutorials->className())->toBe('bg-theme-danger-400');
});

it('can get label', function () {
    expect(Category::News->label())->toBe('News');
    expect(Category::Editorials->label())->toBe('Editorials');
    expect(Category::Updates->label())->toBe('Updates');
    expect(Category::Tutorials->label())->toBe('Tutorials');
});

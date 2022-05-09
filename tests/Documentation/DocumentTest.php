<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Documentation\Document;
use ARKEcosystem\Foundation\Providers\DocumentationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    (new DocumentationServiceProvider(app()))->boot();

    Storage::fake('docs');

    app('files')->copyDirectory(__DIR__.'/fixtures/', Storage::disk('docs')->getAdapter()->getPathPrefix());
});

function createMockRequest(string $path)
{
    $request = test()->partialMock(Request::class);

    $request->shouldReceive('path')
        ->andReturn($path)
        ->atLeast()
        ->once();

    return $request;
}

it('should render', function () {
    $document = Document::find('96b64ffdde7482ccbb3896a39ff3949c');

    expect($document->body)->toContain('title: Cryptoasset Integrations');
    expect(Blade::render($document->body))->toContain('Cryptoasset Integrations');
});

it('should not highlight intro in sidebar', function () {
    app()->instance('request', createMockRequest('/docs/installation'));

    $document = Document::find('0d6eaf5f0b12c40882e0a648eecec8e5');

    expect($document->body)->toContain('<x-ark-docs-sidebar-link first top-level path="/docs/intro" name="Introduction" />');

    expect(Blade::render($document->body))->not->toMatch(
        '/<div class=".+border-theme-primary-600"><\/div>\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-primary-600 bg-theme-primary-100 lg:my-1">\s+'.
        '<a\s+href="\/docs\/intro" class="flex items-center block font-semibold w-full lg:w-58 leading-tight py-4 lg:py-3"/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div class="w-1 -mr-1 z-10"><\/div>\s+<div class="w-full lg:h-auto h-13">\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-secondary-900 hover:text-theme-primary-600">\s+'.
        '<a\s+href="\/docs\/intro"/'
    );
});

it('should highlight intro in sidebar when at root category url', function () {
    app()->instance('request', createMockRequest('/docs'));

    $document = Document::find('0d6eaf5f0b12c40882e0a648eecec8e5');

    expect($document->body)->toContain('<x-ark-docs-sidebar-link first top-level path="/docs/intro" name="Introduction" />');

    expect(Blade::render($document->body))->not->toMatch(
        '/<div class="w-1 -mr-1 z-10"><\/div>\s+<div class="w-full lg:h-auto h-13">\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-secondary-900 hover:text-theme-primary-600">\s+'.
        '<a\s+href="\/docs\/intro"/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div class=".+bg-theme-primary-600.+"><\/div>\s+<div class="w-full lg:h-auto h-13">\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-primary-600 bg-theme-primary-100 lg:my-1">\s+'.
        '<a\s+href="\/docs\/intro"\s+class="flex items-center block font-semibold w-full lg:w-58 leading-tight py-4 lg:py-3"/'
    );
});

it('should highlight intro in sidebar when at category intro url', function () {
    app()->instance('request', createMockRequest('/docs/intro'));

    $document = Document::find('0d6eaf5f0b12c40882e0a648eecec8e5');

    expect($document->body)->toContain('<x-ark-docs-sidebar-link first top-level path="/docs/intro" name="Introduction" />');

    expect(Blade::render($document->body))->not->toMatch(
        '/<div class="w-1 -mr-1 z-10"><\/div>\s+<div class="w-full lg:h-auto h-13">\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-secondary-900 hover:text-theme-primary-600">\s+'.
        '<a\s+href="\/docs\/intro"/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div class="absolute h-full -left-2.5px z-10 border-l-4 rounded-lg border-transparent"><\/div>\s+'.
        '<a\s+href="\/docs\/user-guides\/transactions\/how-to-vote-unvote"/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div class=".+bg-theme-primary-600.+"><\/div>\s+<div class="w-full lg:h-auto h-13">\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-primary-600 bg-theme-primary-100 lg:my-1">\s+'.
        '<a\s+href="\/docs\/intro"\s+class="flex items-center block font-semibold w-full lg:w-58 leading-tight py-4 lg:py-3"/'
    );
});

it('should highlight different page in sidebar', function () {
    app()->instance('request', createMockRequest('/docs/user-guides/transactions/how-to-vote-unvote'));

    $document = Document::find('0d6eaf5f0b12c40882e0a648eecec8e5');

    expect($document->body)->toContain('<x-ark-docs-sidebar-link path="/docs/user-guides/transactions/how-to-vote-unvote" name="Vote or Unvote a Delegate" />');

    expect(Blade::render($document->body))->not->toMatch(
        '/<div class="absolute h-full -left-2.5px z-10 border-l-4 rounded-lg border-transparent"><\/div>\s+'.
        '<a\s+href="\/docs\/user-guides\/transactions\/how-to-vote-unvote"/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div class="w-1 -mr-1 z-10"><\/div>\s+<div class="w-full lg:h-auto h-13">\s+'.
        '<div class="lg:rounded-r w-full pl-4 lg:pl-6 text-theme-secondary-900 hover:text-theme-primary-600">\s+'.
        '<a\s+href="\/docs\/intro"/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div class=".+border-theme-primary-600"><\/div>\s+'.
        '<a\s+href="\/docs\/user-guides\/transactions\/how-to-vote-unvote"/'
    );
});

it('should expand getting started section in sidebar', function () {
    app()->instance('request', createMockRequest('/docs/user-guides/getting-started/installation'));

    $document = Document::find('0d6eaf5f0b12c40882e0a648eecec8e5');

    expect(Blade::render($document->body))->not->toMatch(
        '/<div\s+class="sidebar-group"\s+x-data="{ open: true }"\s+:class="{ \'last:pb-4\': ! open }"\s+x-cloak\s+>\s+'.
        '<button\s+type="button"\s+class="flex items-center justify-between w-full pr-5 py-4 border-theme-secondary-300 group border-t"\s+'.
        '@click.prevent="open = ! open"\s+>\s+'.
        '<h2 class="mb-0 text-base font-semibold text-left accordion-heading text-theme-secondary-900 group-hover:text-theme-primary-600">\s+Transactions/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div\s+class="sidebar-group"\s+x-data="{ open: true }"\s+:class="{ \'last:pb-4\': ! open }"\s+x-cloak\s+>\s+'.
        '<button\s+type="button"\s+class="flex items-center justify-between w-full pr-5 py-4 border-theme-secondary-300 group border-t"\s+'.
        '@click.prevent="open = ! open"\s+>\s+'.
        '<h2 class="mb-0 text-base font-semibold text-left accordion-heading text-theme-secondary-900 group-hover:text-theme-primary-600">\s+Getting Started/'
    );
});

it('should expand transactions section in sidebar', function () {
    app()->instance('request', createMockRequest('/docs/user-guides/transactions/how-to-vote-unvote'));

    $document = Document::find('0d6eaf5f0b12c40882e0a648eecec8e5');

    expect(Blade::render($document->body))->not->toMatch(
        '/<div\s+class="sidebar-group"\s+x-data="{ open: true }"\s+:class="{ \'last:pb-4\': ! open }"\s+x-cloak\s+>\s+'.
        '<button\s+type="button"\s+class="flex items-center justify-between w-full pr-5 py-4 border-theme-secondary-300 group border-t"\s+'.
        '@click.prevent="open = ! open"\s+>\s+'.
        '<h2 class="mb-0 text-base font-semibold text-left accordion-heading text-theme-secondary-900 group-hover:text-theme-primary-600">\s+Getting Started/'
    );

    expect(Blade::render($document->body))->toMatch(
        '/<div\s+class="sidebar-group"\s+x-data="{ open: true }"\s+:class="{ \'last:pb-4\': ! open }"\s+x-cloak\s+>\s+'.
        '<button\s+type="button"\s+class="flex items-center justify-between w-full pr-5 py-4 border-theme-secondary-300 group border-t"\s+'.
        '@click.prevent="open = ! open"\s+>\s+'.
        '<h2 class="mb-0 text-base font-semibold text-left accordion-heading text-theme-secondary-900 group-hover:text-theme-primary-600">\s+Transactions/'
    );
});

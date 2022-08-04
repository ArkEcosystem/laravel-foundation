<?php

declare(strict_types=1);

use function Tests\createViewAttributes;

it('should render the font', function (): void {
    $this
        ->view('ark::font-loader', createViewAttributes(['src' => 'https://font.woff']))
        ->assertSeeHtml('<link rel="preconnect" href="https://font.woff" crossorigin />')
        ->assertSeeHtml('<link rel="preload" as="style" href="https://font.woff" />')
        ->assertSeeHtml('<link rel="stylesheet" href="https://font.woff" media="print" onload="this.media=\'all\'" />')
        ->assertSeeHtml('<noscript><link rel="stylesheet" href="https://font.woff" /></noscript>');
});

it('should render the font with a different pre-connect source', function (): void {
    $this
        ->view('ark::font-loader', createViewAttributes(['src' => 'https://font.woff', 'preconnect' => 'https://pre.font.woff']))
        ->assertSeeHtml('<link rel="preconnect" href="https://pre.font.woff" crossorigin />')
        ->assertSeeHtml('<link rel="preload" as="style" href="https://font.woff" />')
        ->assertSeeHtml('<link rel="stylesheet" href="https://font.woff" media="print" onload="this.media=\'all\'" />')
        ->assertSeeHtml('<noscript><link rel="stylesheet" href="https://font.woff" /></noscript>');
});

it('should render the font from google fonts with display swap', function (): void {
    $this
        ->view('ark::font-loader', createViewAttributes(['src' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap', 'preconnect' => 'https://fonts.gstatic.com']))
        ->assertSeeHtml('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />')
        ->assertSeeHtml('<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />')
        ->assertSeeHtml('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" media="print" onload="this.media=\'all\'" />')
        ->assertSeeHtml('<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" /></noscript>');
});

it('should render the font from google fonts forcing display swap', function (): void {
    $this
        ->view('ark::font-loader', createViewAttributes(['src' => 'https://fonts.googleapis.com/css2?family=Inter:wght@400', 'preconnect' => 'https://fonts.gstatic.com']))
        ->assertSeeHtml('<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />')
        ->assertSeeHtml('<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" />')
        ->assertSeeHtml('<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" media="print" onload="this.media=\'all\'" />')
        ->assertSeeHtml('<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" /></noscript>');
});

<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use NunoMaduro\LaravelMojito\InteractsWithViews;
use Tests\TestCase;
use Tests\Blog\TestCase as BlogTestCase;

uses(TestCase::class, InteractsWithViews::class, RefreshDatabase::class)->in(
    'Analysis',
    'CommonMark',
    'DataBags',
    'Documentation',
    'Fortify',
    'NumberFormatter',
    'Rules',
    'Support',
    'UserInterface',
);
uses(BlogTestCase::class, RefreshDatabase::class)->in('Blog');

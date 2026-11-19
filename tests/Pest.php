<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Blog\TestCase as BlogTestCase;
use Tests\Rules\TestCase as RulesTestCase;
use Tests\TestCase;
use Tests\WithoutLivewire\TestCase as WithoutLivewireTestCase;

uses(TestCase::class, RefreshDatabase::class)->in(
    'Analysis',
    'CommonMark',
    'DataBags',
    'Documentation',
    'NumberFormatter',
    'Support',
    'UserInterface',
);
uses(BlogTestCase::class)->in('Blog');
uses(RulesTestCase::class)->in('Rules');
uses(WithoutLivewireTestCase::class)->in('WithoutLivewire');

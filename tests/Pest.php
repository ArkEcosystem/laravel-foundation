<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Blog\TestCase as BlogTestCase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->in(
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

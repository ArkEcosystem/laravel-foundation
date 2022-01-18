<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$app    = require getcwd().'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$kernel->handle($request = Request::capture());

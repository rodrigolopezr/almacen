<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

foreach (File::allFiles(__DIR__ . '/routes') as $route_file) {
    require $route_file->getPathname();
}

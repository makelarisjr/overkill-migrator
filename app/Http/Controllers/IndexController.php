<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class IndexController extends Controller
{
    public function __invoke(): string
    {
        // kinda hacky way to return the view
        // without using the blade engine
        return File::get(resource_path('views/index.blade.php'));
    }
}

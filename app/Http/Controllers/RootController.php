<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class RootController extends Controller
{
    public function getIndex(): Renderable
    {
        return view('index');
    }
}

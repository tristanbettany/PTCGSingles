<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Set;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class RootController extends Controller
{
    public function getIndex(Request $request): Renderable
    {
        $set = null;
        if (empty($request->has('set')) === false) {
            $set = Set::find($request->get('set'));
        }

        return view('index')
            ->with('series', Series::all())
            ->with('set', $set);
    }
}

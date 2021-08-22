<?php

namespace App\Http\Controllers;

use App\Models\Series;
use App\Models\Set;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use DateTimeImmutable;

class RootController extends Controller
{
    public function getIndex(Request $request): Renderable
    {
        if ($request->has('set') === true) {
            $set = Set::find($request->get('set'));
        }

        if ($request->has('set') === false) {
            $latestSets = Set::query()
                ->where('release_date', '>=', new DateTimeImmutable('2 years ago'))
                ->get();
        }

        return view('index')
            ->with('series', Series::all())
            ->with('set', $set ?? null)
            ->with('latestSets', $latestSets ?? null);
    }
}

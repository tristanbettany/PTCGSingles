@extends('layouts.main')

@section('content')

    @includeIf('partials.set', [
        'set' => $set,
        'releasedCards' => $releasedCards,
    ])

    @includeIf('partials.latest-sets', [
        'latestSets' => $latestSets,
    ])

@endsection

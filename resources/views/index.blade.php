@extends('layouts.main')

@section('content')

    @includeIf('partials.set', [
        'set' => $set,
    ])

    @includeIf('partials.latest-sets', [
        'latestSets' => $latestSets,
    ])

@endsection

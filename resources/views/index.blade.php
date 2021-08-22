@extends('layouts.main')

@section('content')

    @if(empty($set) === false)
        <img src="{{ asset('storage/' . $set->logo) }}"/>
        <div class="flex flex-row justify-start flex-wrap items-start">
            @foreach($set->releasedCards as $card)
                <div class="w-1/4">
                    <img src="{{ asset('storage/' . $card->image) }}"/>
                </div>
            @endforeach
        </div>
    @endif

    @if(empty($latestSets) === false)
        <h2 class="text-32px">Latest Sets</h2>
        <div class="flex flex-row justify-start flex-wrap items-start">
            @foreach($latestSets as $set)
                <div class="w-1/4">
                    <a href="?set={{ $set->id }}"><img src="{{ asset('storage/' . $set->logo) }}"/></a>
                </div>
            @endforeach
        </div>
    @endif

@endsection

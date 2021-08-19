@extends('layouts.main')

@section('content')

    <div class="container mx-auto">

        <div class="flex flex-row justify-start flex-wrap items-start pt-150px">
            <div class="w-1/4">
                @includeIf('partials.sets', [
                    'series' => $series,
                ])
            </div>
            <div class="w-3/4">
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
            </div>
        </div>

    </div>

@endsection

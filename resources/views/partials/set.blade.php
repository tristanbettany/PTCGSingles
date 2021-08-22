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



@if(empty($set) === false)
    <div class="flex flex-row justify-start flex-wrap items-center">
        <div class="w-1/4">
            <img src="{{ asset('storage/' . $set->logo) }}"/>
        </div>
        <div class="w-3/4 pl-20px">
            <p><span class="font-bold">Released:</span> {{ $set->release_date->format('Y-m-d') }}</p>
            <p><span class="font-bold">Total Cards:</span> {{ $set->base_card_count + $set->secret_card_count }}</p>
            <p><span class="font-bold">Secret Cards:</span> {{ $set->secret_card_count }}</p>
            <p><span class="font-bold">Symbol:</span> <img class="inline-block" src="{{ asset('storage/' . $set->symbol) }}"/></p>
        </div>
    </div>

    <div class="flex flex-row justify-start flex-wrap items-start pt-20px">
        @foreach($set->releasedCards as $card)
            <div class="w-1/4">
                <img src="{{ asset('storage/' . $card->image) }}"/>
            </div>
        @endforeach
    </div>
@endif



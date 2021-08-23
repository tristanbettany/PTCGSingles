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
            <div class="w-1/2 flex flex-row justify-start flex-wrap items-start mb-20px">
                <div class="w-1/2">
                    <a href="{{ asset('storage/' . $card->image) }}" target="_blank"><img src="{{ asset('storage/' . $card->image) }}"/></a>
                </div>
                <div class="w-1/2 pl-10px">
                    <h2 class="text-28px pb-10px">{{ $card->name }} {{ $card->paddedNumber() }}/{{ $set->base_card_count }}</h2>
                    <p><span class="font-bold">In hand Qty: </span>{{ $card->in_hand_quantity }}</p>
                    <p class="pb-10px"><span class="font-bold">Tradeable Qty: </span>{{ $card->tradeable_quantity }}</p>
                    <p class="pb-30px"><span class="font-bold">Average Value: </span>£000.00</p>


                    <div class="pb-10px">
                        <div class="w-full flex flex-row justify-start flex-wrap items-center mb-20px">
                            <p class="w-1/2 font-bold">Standard: </p>
                            <div class="w-1/2">
                                <a href="/card/{{ $card->id }}/increment?type=standard" class="bg-pri text-white text-center py-10px w-40px inline-block ml-10px">+</a>
                                <a href="/card/{{ $card->id }}/decrement?type=standard" class="bg-ter-300 text-black text-center py-10px w-40px inline-block ml-10px">-</a>
                            </div>
                        </div>
                    </div>

                    <div class="pb-10px">
                        <div class="w-full flex flex-row justify-start flex-wrap items-center mb-20px">
                            <p class="w-1/2 font-bold">Reverse Holo: </p>
                            <div class="w-1/2">
                                <a href="/card/{{ $card->id }}/increment?type=standard" class="bg-pri text-white text-center py-10px w-40px inline-block ml-10px">+</a>
                                <a href="/card/{{ $card->id }}/decrement?type=standard" class="bg-ter-300 text-black text-center py-10px w-40px inline-block ml-10px">-</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif



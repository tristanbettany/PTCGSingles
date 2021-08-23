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
                <div class="w-1/2 px-10px">
                    <h2 class="text-28px pb-10px">{{ $card->name }} {{ $card->paddedNumber() }}/{{ $set->base_card_count }}</h2>

                    @foreach($card->versions as $version)

                        <div class="mb-20px">
                            <div class="w-full px-10px py-5px mb-5px {{ $version->is_standard === true ? 'bg-pri' : 'bg-ter-300' }}">
                                <p class="{{ $version->is_standard === true ? 'text-white' : 'text-black' }}">{{ $version->is_standard === true ? 'Standard' : 'Reverse Holo' }}</p>
                            </div>
                            <div class="pl-10px">
                                <p><span class="font-bold">Quantity: </span>{{ $version->quantity }}</p>
                                <p><span class="font-bold">Value: </span>£{{ $version->value }}</p>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        @endforeach
    </div>
@endif



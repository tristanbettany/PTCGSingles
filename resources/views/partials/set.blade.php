@if(empty($set) === false)
    <div class="">
        <div class="flex flex-row justify-start flex-wrap items-center">
            <div class="w-1/4">
                <img src="{{ asset('storage/' . $set->logo) }}"/>
            </div>
            <div class="w-1/4 pl-20px">
                <p><span class="font-bold">Released:</span> {{ $set->release_date->format('Y-m-d') }}</p>
                <p><span class="font-bold">Total Cards:</span> {{ $set->base_card_count + $set->secret_card_count }}</p>
                <p><span class="font-bold">Secret Cards:</span> {{ $set->secret_card_count }}</p>
                <p><span class="font-bold">Symbol:</span> <img class="inline-block" src="{{ asset('storage/' . $set->symbol) }}"/></p>
            </div>
            <div class="w-1/4 pl-20px">
                <p><span class="font-bold">Versions With Stock:</span> <span id="versions-with-stock">{{ $set->withStock() }}</span></p>
                <p><span class="font-bold">Versions With Duplicates:</span> <span id="versions-with-duplicates">{{ $set->withDuplicates() }}</span></p>
                <p><span class="font-bold">Total On Hand Versions:</span> <span id="total-on-hand-versions">{{ $set->totalOnHand() }}</span></p>
                <p><span class="font-bold">Total Duplicate Versions:</span> <span id="total-duplicate-versions">{{ $set->totalDuplicates() }}</span></p>
            </div>
            <div class="w-1/4 pl-20px">
                <p><span class="font-bold">Versions Without Stock:</span> <span id="versions-without-stock">{{ $set->missingStock() }}</span></p>
                <p><span class="font-bold">Versions Missing Values:</span> <span id="versions-missing-values">{{ $set->missingValues() }}</span></p>
                <p><span class="font-bold">On Hand Value:</span> <span id="on-hand-value">{{ $set->onHandValue() }}</span></p>
                <p><span class="font-bold">Duplicates Value:</span> <span id="duplicates-value">{{ $set->duplicatesValue() }}</span></p>
            </div>
        </div>
    </div>

    <div class="flex flex-row justify-start flex-wrap items-start pt-20px">
        @foreach($set->releasedCards as $card)
            <div class="w-1/2 flex flex-row justify-start flex-wrap items-start mb-20px">
                <div class="w-1/2">
                    <a href="{{ asset('storage/' . $card->image) }}" target="_blank"><img src="{{ asset('storage/' . $card->image) }}"/></a>
                </div>
                <div class="w-1/2 px-10px">
                    <h2 class="text-28px pb-20px">{{ $card->name }} {{ $card->paddedNumber() }}/{{ $set->base_card_count }}</h2>

                    @foreach($card->versions as $version)

                        <div class="mb-20px">
                            <div class="w-full mb-10px">
                                <p class="text-black font-bold">{{ $version->is_standard === true ? 'Standard' : 'Reverse Holo' }}</p>
                            </div>
                            <div class="flex flex-row justify-start flex-wrap items-baseline">
                                <div class="w-1/3">
                                    <input
                                        id="card{{ $card->id }}-version{{ $version->id }}-quantity"
                                        class="form-input py-5px"
                                        type="number"
                                        value="{{ $version->quantity() }}"
                                        placeholder="Quantity"
                                    />
                                </div>
                                <div class="w-1/3">
                                    <button
                                        data-card-id="{{ $card->id }}"
                                        data-version-id="{{ $version->id }}"
                                        class="bg-pri-500 text-white text-center hover:bg-white border-2 border-pri-500 hover:text-black py-5px px-10px w-full"
                                        onclick="updateQuantity(this)"
                                    >
                                        Update
                                    </button>
                                </div>
                                <div class="w-1/3">
                                    <button
                                        data-card-id="{{ $card->id }}"
                                        data-version-id="{{ $version->id }}"
                                        class="text-center cursor-pointer px-10px py-5px bg-error-500 text-white border-2 border-error-500 w-full block"
                                        onclick="scrapeValue(this)"
                                    >
                                        £ {{ $version->value ?? 00.00 }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
        @endforeach
    </div>
@endif

<script>
    function updateQuantity(button) {
        let cardId = button.getAttribute('data-card-id')
        let versionId = button.getAttribute('data-version-id')
        let quantityEl = document.getElementById('card'+cardId+'-version'+versionId+'-quantity')

        let metaVersionsWithStock = document.getElementById('versions-with-stock')
        let metaVersionsWithDuplicates = document.getElementById('versions-with-duplicates')
        let metaTotalOnHandVersions = document.getElementById('total-on-hand-versions')
        let metaTotalDuplicateVersions = document.getElementById('total-duplicate-versions')
        let metaVersionsWithoutStock = document.getElementById('versions-without-stock')
        let metaVersionsMissingValues = document.getElementById('versions-missing-values')
        let metaOnHandValue = document.getElementById('on-hand-value')
        let metaDuplicatesValue = document.getElementById('duplicates-value')

        axios.post('/api/cards/'+cardId+'/versions/'+versionId, {
            quantity: quantityEl.value,
        }).then(function (response) {
            quantityEl.value = response.data.quantity
            metaVersionsWithStock.innerHTML = response.data.versionsWithStock;
            metaVersionsWithDuplicates.innerHTML = response.data.versionsWithDuplicates;
            metaTotalOnHandVersions.innerHTML = response.data.totalOnHandVersions;
            metaTotalDuplicateVersions.innerHTML = response.data.totalDuplicateVersions;
            metaVersionsWithoutStock.innerHTML = response.data.versionsWithoutStock;
            metaVersionsMissingValues.innerHTML = response.data.versionsMissingValues;
            metaOnHandValue.innerHTML = response.data.onHandValue;
            metaDuplicatesValue.innerHTML = response.data.duplicatesValue;
        }).catch(function (error) {
            console.log(error)
        })
    }

    function scrapeValue(button) {
        let cardId = button.getAttribute('data-card-id')
        let versionId = button.getAttribute('data-version-id')

        axios.get('/api/cards/'+cardId+'/versions/'+versionId+'/scrape-value').then(function (response) {
            button.innerHTML = '£ '+response.data.value
        }).catch(function (error) {
            console.log(error)
        })
    }
</script>

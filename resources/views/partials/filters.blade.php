<form method="GET">
    @csrf
    <input type="hidden" name="set" value="{{ $set->id }}" />

    <div class="flex flex-row justify-start items-baseline flex-wrap pt-20px flex-row-reverse">

        <div class="w-full sm:w-1/4 sm:px-10px">
            <button class="bg-pri-500 hover:bg-white hover:text-black text-white text-center border-2 border-pri-500 w-full py-5px" name="filter">Filter Cards</button>
        </div>

        <div class="w-full sm:w-1/4 sm:px-10px">
            <div class="form-select-container">
                <select class="form-select" name="filter_type">
                    @includeIf('partials.select-options', [
                        'options' => \App\Services\SetService::FILTER_OPTIONS,
                        'selected' => request()->has('filter_type') === true ? request()->get('filter_type') : \App\Services\SetService::NONE,
                    ])
                </select>
                @includeIf('partials.select-icon')
            </div>
        </div>

        <div class="w-full sm:w-1/4 sm:px-10px">
            <a href="?set={{ $set->id }}&export=needs" class="w-full block bg-ter-200 hover:bg-white text-black text-center border-2 border-ter-200 w-full py-5px" name="filter">Export Needs</a>
        </div>

        <div class="w-full sm:w-1/4 sm:px-10px">
            <a href="?set={{ $set->id }}&export=swaps" class="w-full block bg-ter-200 hover:bg-white text-black text-center border-2 border-ter-200 w-full py-5px" name="filter">Export Swaps</a>
        </div>

    </div>
</form>

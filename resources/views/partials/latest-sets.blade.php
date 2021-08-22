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

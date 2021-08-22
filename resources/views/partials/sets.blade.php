@foreach($series as $seri)
    <div class="flex flex-row justify-start flex-wrap items-start pb-20px">
        <div class="w-full">
            <h2 class="text-32px">{{ $seri->name }}</h2>
        </div>

        @foreach($seri->sets as $set)
            <div class="w-full">
                <a class="link sec pb-10px" href="?set={{ $set->id }}">{{ $set->name }}</a>
            </div>
        @endforeach
    </div>
@endforeach



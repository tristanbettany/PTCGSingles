<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <title>PTCG Singles</title>
    <script src="https://kit.fontawesome.com/a016df5e6e.js" crossorigin="anonymous"></script>
</head>
<body>

    <div class="w-full p-20px bg-pri">
        <div class="container mx-auto">
            <a href="/"><img class="h-100px" src="{{ asset('img/logo.png') }}" /></a>
        </div>
    </div>

    <div class="container mx-auto mt-20px">

        <div class="flex flex-row justify-start flex-wrap items-start ">
            <div class="w-1/4">
                @includeIf('partials.sets', [
                    'series' => $series,
                ])
            </div>
            <div class="w-3/4">
                @yield('content')
            </div>
        </div>

    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            @if(View::hasSection('title'))
                @yield('title') | {{ config('app.name')}}
            @else
                {{ config('app.name') }}
            @endif
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/guest.css', 'resources/js/guest.js'])

    </head>
    <body class="relative font-sans antialiased bg-slate-200">
        <x-toast/>
        <div class="flex h-screen w-screen items-center justify-center scrollbar-hide">
            @yield('content')
        </div>
        @stack('scripts')
    </body>
</html>

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
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="relative font-sans antialiased">
        <x-toast/>
        <div class="flex h-screen w-screen items-center justify-center bg-slate-200 scrollbar-hide">
            <x-sidebar />
            <div class="flex flex-col w-full lg:pl-[270px] transition-all">
                <x-navbar />

                <div class="py-4 m-2 rounded-lg h-screen overflow-auto scrollbar-hide">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>

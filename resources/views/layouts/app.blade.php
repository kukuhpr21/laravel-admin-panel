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
        @stack('head')
    </head>
    <body class="relative h-screen w-screen bg-slate-200 font-sans antialiased scrollbar-hide">
        <x-toast/>
        <div class="flex items-center justify-center">
            <x-sidebar />
            <div class="flex flex-col w-full lg:pl-[270px] transition-all scrollbar-hide">
                <x-navbar />

                <div class="py-4 m-2 rounded-lg h-screen overflow-auto scrollbar-hide">
                    @yield('content')
                </div>
            </div>
        </div>
        @stack('scripts')
    </body>
</html>

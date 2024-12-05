<nav class="flex flex-row items-center justify-between sticky top-0 z-50 w-full bg-slate-200 p-2">
    <div class="flex flex-row gap-2 items-center">
        <button class="lg:hidden hover:rounded-xl hover:bg-slate-100 hover:drop-shadow-lg p-2" aria-haspopup="dialog" aria-expanded="false" aria-controls="sidebar" aria-label="Toggle navigation" data-hs-overlay="#sidebar">
            <i class="ri-align-left ri-xl"></i>
        </button>
        <div class="flex flex-col">
            <span class="sm:text-sm text-xs text-slate-600 font-normal drop-shadow-sm">Hello,</span>
            <span class="sm:text-base text-sm text-slate-700 font-semibold drop-shadow-sm">{{ $name }}</span>
        </div>
    </div>
    <div class="hs-dropdown relative inline-flex mr-2">
        <button id="hs-dropdown-with-dividers" type="button" class="hs-dropdown-toggle lg:py-3 py-2 lg:px-4 px-3 inline-flex items-center lg:gap-x-2 gap-x-1 lg:text-sm text-xs lg:font-medium font-normal rounded-full border border-gray-300 bg-white text-gray-800 drop-shadow-xl hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
            <div class="flex flex-row lg:gap-2 gap-1">
                <span class="flex size-[38px] items-center justify-center text-gray-800 bg-gray-300 rounded-full overflow-hidden">
                    <i class="ri-user-line lg:ri-xl ri-lg"></i>
                </span>
                <div class="flex flex-col items-start">
                    <span class="sm:text-sm text-xs text-slate-700 lg:font-normal font-light">{{ $name }}</span>
                    <span class="text-xs text-slate-400 font-light">{{ $role }}</span>
                </div>
            </div>
            <svg class="hs-dropdown-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
        </button>

        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full" role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-hover-event">
            <div class="p-1 space-y-0.5">
                <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100" href="#">
                Profile
                </a>
            </div>
            <div class="p-1 space-y-0.5">
                <button type="button" class="flex w-full items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                    Log Out
                </button>
            </div>
        </div>
    </div>
</nav>

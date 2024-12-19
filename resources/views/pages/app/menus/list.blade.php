@extends('layouts.app')
@section('title', 'Daftar Menu')
@section('content')
<x-page title="Daftar Menu">
    <div class="flex flex-col justify-end pb-3">
        <button type="button" class="hs-collapse-toggle w-fit py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-blue-500 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" id="hs-basic-collapse" aria-expanded="false" aria-controls="hs-basic-collapse-heading" data-hs-collapse="#hs-basic-collapse-heading">
            Preview Menu
            <svg class="hs-collapse-open:rotate-180 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m6 9 6 6 6-6"></path>
            </svg>
        </button>
        <div id="hs-basic-collapse-heading" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300 border border-dashed border-1 border-gray-400 mt-2 drop-shadow-md rounded-lg" aria-labelledby="hs-basic-collapse">
            <div class="mt-5 bg-white rounded-lg py-3 px-4">
                {!! $menus !!}
            </div>
        </div>
    </div>
    <x-table :showButtonAdd="true" routeButtonAdd="{{ route('menus-add') }}" :data="$dataTable"/>
</x-page>
@endsection

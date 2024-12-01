@props(['routeName', 'class' => '', 'csrf' => true])
<form action="{{ route($routeName) }}" method="POST" class="flex flex-col gap-3 py-3 px-4 bg-blue-50 rounded-2xl drop-shadow-2xl shadow-white w-full {{ $class }}">
    @if ($csrf)
        @csrf
    @endif
    {{ $slot }}
</form>

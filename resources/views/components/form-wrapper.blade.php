@props(['action', 'method' => 'POST'])

<div class="py-8 mx-auto sm:max-w-xl" {{ $attributes }}>
    <form action="{{ $action }}" method="{{ $method }}" class="flex flex-col px-8 pb-8 border-b-2 sm:pt-8 sm:rounded-xl sm:border-2 border-theme-secondary-200">
        @csrf
        {{ $slot  }}
    </form>
</div>

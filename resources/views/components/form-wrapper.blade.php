@props(['action', 'method' => 'POST', 'class' => 'py-8 mx-auto sm:max-w-xl'])

<div {{ $attributes->merge(['class' => $class]) }}>
    <form action="{{ $action }}" method="{{ $method }}"
        class="flex flex-col border-b-2 border-theme-secondary-200 px-8 pb-8 dark:border-theme-secondary-800 sm:rounded-xl sm:border-2 sm:pt-8">
        @csrf
        {{ $slot }}
    </form>
</div>

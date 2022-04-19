@props([
    'text' => trans('ui::generic.search.no_results'),
])

<div {{ $attributes->class('flex flex-col justify-center justify-between items-center py-4 px-6 rounded-xl border sm:items-start md:flex-row md:items-center border-theme-secondary-300 dark:border-theme-secondary-800 dark:text-theme-secondary-500') }}>
    <span class="text-center w-full">
        {{ $text }}
    </span>
</div>

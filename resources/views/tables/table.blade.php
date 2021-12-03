@props([
    'sticky' => false,
    'tableClass' => '',
    'noContainer' => false,
    'compact' => false,
    'compactUntil' => 'md',
])

@unless ($noContainer)
    <div {{ $attributes->merge(['class' => 'table-container']) }}>
@endunless
    <table
        @class([
            $tableClass,
            'sticky-headers' => $sticky,
            'table-compact'=> $compact,
            'table-compact-until-' . $compactUntil => $compact && $compactUntil,
        ])
    >
        {{ $slot }}
    </table>
@unless ($noContainer)
    </div>
@endunless

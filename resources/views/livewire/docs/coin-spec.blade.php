<div>
    @foreach($sections as $title => $table)
        <div class="mb-4">
            <x-ark-accordion :title="$title">
                @markdown($table)
            </x-ark-accordion>
        </div>
    @endforeach
</div>

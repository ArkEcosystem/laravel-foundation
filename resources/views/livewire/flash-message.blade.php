<div>
    @if($message)
        <x-ark-alert :type="$this->alertType()">
            {!! $message !!}
        </x-ark-alert>
    @endif
</div>

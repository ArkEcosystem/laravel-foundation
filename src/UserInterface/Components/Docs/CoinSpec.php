<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components\Docs;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class CoinSpec extends Component
{
    /**
     * @var mixed|null
     */
    public $spec;

    public function mount(string $spec): void
    {
        $this->spec = json_decode(Storage::disk('docs')->get($spec), true);
    }

    public function render(): View
    {
        $sections = [];

        foreach ($this->spec as $class => $functions) {
            $table = 'Functions                 | Supported          |'.PHP_EOL;
            $table .= '------------------------- | ------------------ |'.PHP_EOL;

            foreach ($functions as $name => $supported) {
                if (is_array($supported)) {
                    foreach ($supported as $argumentName => $argumentSupported) {
                        if ($argumentSupported) {
                            $table .= $name.'('.$argumentName.') | :white_check_mark: |'.PHP_EOL;
                        } else {
                            $table .= $name.'('.$argumentName.') | :x: |'.PHP_EOL;
                        }
                    }
                } elseif ($supported) {
                    $table .= $name.' | :white_check_mark: |'.PHP_EOL;
                } else {
                    $table .= $name.' | :x: |'.PHP_EOL;
                }
            }

            $sections[$class] = $table;
        }

        return view('ark::livewire.docs.coin-spec', [
            'sections' => $sections,
        ]);
    }
}

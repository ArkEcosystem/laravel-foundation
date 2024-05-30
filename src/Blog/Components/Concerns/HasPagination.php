<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Components\Concerns;

use Livewire\WithPagination;

trait HasPagination
{
    use WithPagination;

    /**
     * Livewire's WithPagination trait checks whether there's an `updatedPaginators` method
     * and it will fire after page has changed if the method exists.
     *
     * @return void
     */
    public function updatedPaginators() : void
    {
        $this->dispatch('pageChanged');
    }
}
